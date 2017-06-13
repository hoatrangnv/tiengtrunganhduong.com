<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 6/3/2017
 * Time: 10:34 AM
 */

namespace console\controllers;


use backend\models\Image;
use common\helpers\MyStringHelper;
use common\models\Article;
use common\models\ArticleCategory;
use console\models\CrawledPage;
use console\models\Crawler;
use yii\console\Controller;
use PHPHtmlParser\Dom;
use yii\helpers\Console;
use yii\helpers\Inflector;
use yii\helpers\VarDumper;

class CrawlController extends Controller
{
    public static $sitemap_filename;
    public static $ga_filename;

    public $offset = 0;

    public $limit = 10000;

    public $delay = 0;

    public function options($actionID)
    {
        return ['offset', 'limit', 'delay'];
    }

    public function optionAliases()
    {
        return ['o' => 'offset', 'l' => 'limit', 'd' => 'delay'];
    }

    public function beforeAction($action)
    {
        self::$sitemap_filename = __DIR__ . '/../data/tiengtrunganhduong.xml';
        self::$ga_filename = __DIR__ . '/../data/ga.txt';
        return parent::beforeAction($action);
    }

    public function actionCountUrls()
    {
        $sitemap_content = file_get_contents(self::$sitemap_filename);
        $doc = new \DOMDocument('1.0', 'UTF-8');
        $doc->loadXML($sitemap_content);
        echo $doc->getElementsByTagName('loc')->length;
    }

    public function actionGa()
    {
        ini_set('memory_limit', '1024M');
        ini_set('default_socket_timeout', 600);
        $ga_content = file_get_contents(self::$ga_filename);
        $relativeUrls = json_decode($ga_content);
        $errorsLog = [];
        echo count($relativeUrls) . "\n";
        for ($i = $this->offset; $i < count($relativeUrls) && $i < $this->offset + $this->limit; $i++) {

            $url = $relativeUrls[$i];

            $url = 'http://tiengtrunganhduong.com' . parse_url($url, PHP_URL_PATH);

            echo "\n------------------[ $i ]------------------\n";

            echo "$url\n";

            if ($crawler = Crawler::find()->where(['url' => $url])->one()) {
                if (!!$crawler->content && strpos($crawler->status, '200 OK') !== false) {
                    echo "Ignore: Crawler#$crawler->id have already existed and has full info\n";
                    continue;
                }
                echo "Update existed crawler#$crawler->id:\n";
            } else {
                $crawler = new Crawler();
                echo "New crawler:\n";
            }

            $crawler->time = date('Y-m-d H:i:s');
            $crawler->url = $url;

            if (strpos($url, 'http://m.tiengtrunganhduong.com') !== false) {
                echo $this->stdout("Ignore mobile version", Console::BG_YELLOW);
                echo "\n";
                if ($crawler->isNewRecord) {
                    if ($crawler->save()) {
                        $msg = "Saved (url) Crawler#$crawler->id\n";
                    } else {
                        $msg = VarDumper::dumpAsString($crawler->getErrors()) . "\n";
                        $errorsLog[] = [
                            $crawler->id,
                            $crawler->url,
                            $crawler->type,
                            $crawler->status,
                            $msg
                        ];
                    }
                    echo $msg;
                }
                continue;
            }

            try {
                $content = file_get_contents($crawler->url);

                $crawler->status = $http_response_header[0];

                if (strpos($crawler->status, '200 OK') === false) {
                    $crawler->error_message = 'Ignore Status: ' . $crawler->status;
                    echo $crawler->error_message . "\n";
                    if ($crawler->save()) {
                        $msg = "Saved (url, status) Crawler#$crawler->id\n";
                    } else {
                        $msg = VarDumper::dumpAsString($crawler->getErrors()) . "\n";
                        $errorsLog[] = [
                            $crawler->id,
                            $crawler->url,
                            $crawler->type,
                            $crawler->status,
                            $msg
                        ];
                    }
                    echo $msg;
                    continue;
                }

                $crawler->type = $http_response_header[2];

                if (strpos($crawler->type, 'text/html') === false) {
                    $crawler->error_message = 'Ignore Type: ' . $crawler->type;
                    echo $crawler->error_message . "\n";
                    if ($crawler->save()) {
                        $msg = "Saved (url, status, type) Crawler#$crawler->id\n";
                    } else {
                        $msg = VarDumper::dumpAsString($crawler->getErrors()) . "\n";
                        $errorsLog[] = [
                            $crawler->id,
                            $crawler->url,
                            $crawler->type,
                            $crawler->status,
                            $msg
                        ];
                    }
                    echo $msg;
                    continue;
                }

                $crawler->content = $content;
                if ($crawler->save()) {
                    $msg = "Saved (*) Crawler#$crawler->id successfully\n";
                    echo $this->stdout($msg, Console::FG_GREEN);
                } else {
                    $msg = VarDumper::dumpAsString($crawler->getErrors()) . "\n";
                    $errorsLog[] = [
                        $crawler->id,
                        $crawler->url,
                        $crawler->type,
                        $crawler->status,
                        $msg
                    ];
                    echo $this->stdout($msg, Console::FG_YELLOW);
                }
            } catch (\Exception $exception) {
                $crawler->error_message = $exception->getMessage();
                $errorsLog[] = [
                    $crawler->url,
                    $crawler->error_message
                ];
                echo $this->stdout($crawler->error_message, Console::BG_RED);
                if ($crawler->save()) {
                    $msg = "Saved (url) Crawler#$crawler->id\n";
                } else {
                    $msg = VarDumper::dumpAsString($crawler->getErrors()) . "\n";
                    $errorsLog[] = [
                        $crawler->id,
                        $crawler->url,
                        $crawler->type,
                        $crawler->status,
                        $msg
                    ];
                }
                echo "\n$msg";
            }

            // Echo memory usage
            $mem = date('H:i:s') . ' Current memory usage: ' . (memory_get_usage(true) / 1024 / 1024) . " MB\n";
            // Echo memory peak usage
            $mem .= date('H:i:s') . " Peak memory usage: " . (memory_get_peak_usage(true) / 1024 / 1024) . " MB\n";
            echo $mem;

            if ($this->delay > 0) {
                sleep($this->delay);
            }
        }
        echo "Errors Log:\n";
        var_dump($errorsLog);
    }

    public function actionAllUrl()
    {
        ini_set('memory_limit', '1024M');
        ini_set('default_socket_timeout', 600);
        $sitemap_content = file_get_contents(self::$sitemap_filename);
        $doc = new \DOMDocument('1.0', 'UTF-8');
        $doc->loadXML($sitemap_content);
        /**
         * @var \DOMNode $item
         */
        $errorsLog = [];
        $elements = $doc->getElementsByTagName('loc');
        echo $this->stdout($elements->length, Console::FG_CYAN);
        for ($i = $this->offset; $i < $this->offset + $this->limit; $i++) {
            $item = $elements->item($i);

            if (!is_object($item)) {
                continue;
            }

            $url = $item->textContent;

            echo "\n------------------[ $i ]------------------\n";

            echo "$url\n";

            if ($crawler = Crawler::find()->where(['url' => $url])->one()) {
                if (!!$crawler->content && strpos($crawler->status, '200 OK') !== false) {
                    echo "Ignore: Crawler#$crawler->id have already existed and has full info\n";
                    continue;
                }
                echo "Update existed crawler#$crawler->id:\n";
            } else {
                $crawler = new Crawler();
                echo "New crawler:\n";
            }

            $crawler->time = date('Y-m-d H:i:s');
            $crawler->url = $url;

            if (strpos($url, 'http://m.tiengtrunganhduong.com') !== false) {
                echo $this->stdout("Ignore mobile version", Console::BG_YELLOW);
                echo "\n";
                if ($crawler->isNewRecord) {
                    if ($crawler->save()) {
                        $msg = "Saved (url) Crawler#$crawler->id\n";
                    } else {
                        $msg = VarDumper::dumpAsString($crawler->getErrors()) . "\n";
                        $errorsLog[] = [
                            $crawler->id,
                            $crawler->url,
                            $crawler->type,
                            $crawler->status,
                            $msg
                        ];
                    }
                    echo $msg;
                }
                continue;
            }

            try {
                $content = file_get_contents($crawler->url);

                $crawler->status = $http_response_header[0];

                if (strpos($crawler->status, '200 OK') === false) {
                    $crawler->error_message = 'Ignore Status: ' . $crawler->status;
                    echo $crawler->error_message . "\n";
                    if ($crawler->save()) {
                        $msg = "Saved (url, status) Crawler#$crawler->id\n";
                    } else {
                        $msg = VarDumper::dumpAsString($crawler->getErrors()) . "\n";
                        $errorsLog[] = [
                            $crawler->id,
                            $crawler->url,
                            $crawler->type,
                            $crawler->status,
                            $msg
                        ];
                    }
                    echo $msg;
                    continue;
                }

                $crawler->type = $http_response_header[2];

                if (strpos($crawler->type, 'text/html') === false) {
                    $crawler->error_message = 'Ignore Type: ' . $crawler->type;
                    echo $crawler->error_message . "\n";
                    if ($crawler->save()) {
                        $msg = "Saved (url, status, type) Crawler#$crawler->id\n";
                    } else {
                        $msg = VarDumper::dumpAsString($crawler->getErrors()) . "\n";
                        $errorsLog[] = [
                            $crawler->id,
                            $crawler->url,
                            $crawler->type,
                            $crawler->status,
                            $msg
                        ];
                    }
                    echo $msg;
                    continue;
                }

                $crawler->content = $content;
                if ($crawler->save()) {
                    $msg = "Saved (*) Crawler#$crawler->id successfully\n";
                    echo $this->stdout($msg, Console::FG_GREEN);
                } else {
                    $msg = VarDumper::dumpAsString($crawler->getErrors()) . "\n";
                    $errorsLog[] = [
                        $crawler->id,
                        $crawler->url,
                        $crawler->type,
                        $crawler->status,
                        $msg
                    ];
                    echo $this->stdout($msg, Console::FG_YELLOW);
                }
            } catch (\Exception $exception) {
                $crawler->error_message = $exception->getMessage();
                $errorsLog[] = [
                    $crawler->url,
                    $crawler->error_message
                ];
                echo $this->stdout($crawler->error_message, Console::BG_RED);
                if ($crawler->save()) {
                    $msg = "Saved (url) Crawler#$crawler->id\n";
                } else {
                    $msg = VarDumper::dumpAsString($crawler->getErrors()) . "\n";
                    $errorsLog[] = [
                        $crawler->id,
                        $crawler->url,
                        $crawler->type,
                        $crawler->status,
                        $msg
                    ];
                }
                echo "\n$msg";
            }

            // Echo memory usage
            $mem = date('H:i:s') . ' Current memory usage: ' . (memory_get_usage(true) / 1024 / 1024) . " MB\n";
            // Echo memory peak usage
            $mem .= date('H:i:s') . " Peak memory usage: " . (memory_get_peak_usage(true) / 1024 / 1024) . " MB\n";
            echo $mem;

            if ($this->delay > 0) {
                sleep($this->delay);
            }
        }
        echo "Errors Log:\n";
        var_dump($errorsLog);
    }

    public function actionIndex()
    {
        ini_set('memory_limit', '1024M');
        $sitemap_content = file_get_contents(self::$sitemap_filename);
//        echo strlen($sitemap_content);
        $dom = new Dom;
        $offset = strpos($sitemap_content, 'tu/s/174/12/tags.htm');
        $sitemap_sub_content = '<?xml version="1.0" encoding="UTF-8"?>'
            . ' <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'
            . ' <url> <loc>http://tiengtrunganhduong.com/'
            . substr($sitemap_content, $offset);
        $dom->load($sitemap_sub_content);
        foreach ($dom->find('url > loc') as $item) {
            $url = $item->innerHTML;
            if (strpos($url, 'tiengtrunganhduong.com') === false || CrawledPage::find()->where(['url' => $url])->one()) {
                continue;
            }
            $crawler = new CrawledPage();
            $crawler->url = $url;

            $relative_url = str_replace('http://tiengtrunganhduong.com/', '', $crawler->url);

            if (substr($relative_url, -4) === '.htm') {

                $item_content = file_get_contents($crawler->url);
                $item_dom = new Dom;
                $item_dom->load($item_content);
                $crawler->content = $item_dom->find('html')[0]->innerHTML;
                if ($crawler->save()) {
                    echo $relative_url . "\n";
                } else {
                    var_dump($crawler->getErrors());
                }
                $item_dom = null;
            }
            $crawler = null;
        }
//        var_dump($dom->find('url > loc'));
    }

    public function actionGetArticlesFromCrawlers()
    {
        ini_set('memory_limit', '1024M');

        /**
         * @var Crawler[] $crawlers
         */
        $crawlers = Crawler::find()
            ->where(['!=', 'content', ''])
            ->andWhere(['not in', 'url', [
                'http://tiengtrunganhduong.com/1226/tnd/doi-ngu-giao-vien.htm',
                'http://tiengtrunganhduong.com/trung-tam-tieng-trung-Anh-Duong.htm',
                'http://tiengtrunganhduong.com/bang-chu-cai-tieng-trung.htm',
                'http://tiengtrunganhduong.com/250-tu-vung-tieng-trung-chu-de-thu-vien.htm',
                'http://tiengtrunganhduong.com/bo-quan-ao-nay-hop-voi-toi-khong.htm',
                'http://tiengtrunganhduong.com/dich-ho-ten-tieng-viet-sang-tieng-trung.htm',
                'http://tiengtrunganhduong.com/cong-viec-hang-ngay.htm',
            ]])
            ->andWhere(['not like', 'url', 'http://m.tiengtrunganhduong.com%'])
            ->offset($this->offset)
            ->limit($this->limit)
            ->all();

        $errors = [];

        $total = count($crawlers);

        $new_article_count = 0;
        $new_image_count = 0;

        foreach ($crawlers as $i => $crawler) {

            echo "\n------------[ $i ]------------/$total\n";
            echo $crawler->url . "\n";

            $url_path = parse_url($crawler->url, PHP_URL_PATH);
            $url_slugs = explode('/', $url_path);
            $last_slug = $url_slugs[count($url_slugs) - 1];
            if (substr($last_slug, -4) !== '.htm') {
                continue;
            }

            $slug = substr($last_slug, 0, -4);
            echo "Slug: $slug\n";

            try {
                $dom = new Dom();
                $dom->loadStr($crawler->content, [
                    'whitespaceTextNode' => true,
                    'strict'             => false,
                    'enforceEncoding'    => null,
                    'cleanupInput'       => false,
                    'removeScripts'      => false,
                    'removeStyles'       => false,
                    'preserveLineBreaks' => true,
                ]);
                $h1 = $dom->find('h1.nameOtherNew', 0);
                $content = $dom->find('div.contentNewTop', 0);
                if (!$h1 || !$content) {
                    echo "There is no h1 or content was found\n";
                    continue;
                }

                $article = Article::find()->where(['slug' => $slug])->one();
                if ($article) {
                    echo "Article#$article->id has already existed\n";
                    continue;
                }

                $article = new Article();
                $article->slug = $slug;
                $article->name = $article->meta_title = $h1->innerHTML;
                $article->content = $content->innerHTML;
                if ($article->content === '') {
                    $article->content = $article->name;
                }
                $article->active = 1;
                $article->visible = 1;
                if ($time_div = $dom->find('div.timeNewTop', 0)) {
                    $time = strtotime(str_replace('/', '-', substr($time_div->innerHTML, 0, 10)));
                    $view_count = (int) str_replace(['lượt xem', '-', ' '], '', substr($time_div->innerHTML, 11));
                    $article->create_time = $article->update_time = $article->publish_time = $time;
                    $article->view_count = $view_count;
                    $time_div = null;
                }
                if ($linkRoad = $dom->find('a.linkRoad', 2)) {
                    $catName = $linkRoad->innerHTML;
                    if ($category = ArticleCategory::findOne(['name' => $catName])) {
                        echo "Category#$category->id " . $category->name . " was found\n";
                        $article->category_id = $category->id;
                        $category = null;
                    }
                    $linkRoad = null;
                }
                if ($meta_keywords = $dom->find('meta[name="keywords"]', 0)) {
                    $article->meta_keywords = $meta_keywords->getAttribute('content');
                    $meta_keywords = null;
                }
                if ($meta_description = $dom->find('meta[name="description"]', 0)) {
                    $article->description = $article->meta_description = $meta_description->getAttribute('content');
                    $meta_description = null;
                }
                if ($meta_ogImage = $dom->find('meta[property="og:image"]', 0)) {
                    $image_source = $meta_ogImage->getAttribute('content');
                    $image = new Image();
                    $image->image_source = $image_source;
                    $image->name = $article->name;
                    $image->create_time = $article->create_time;
                    $image->update_time = $article->update_time;
                    $image->active = 1;
                    try {
                        if ($image->saveFileAndModel()) {
                            $new_image_count++;
                            $article->image_id = $image->id;
                            echo $this->stdout("Saved Image#$image->id successfully\n", Console::FG_CYAN);;
                        } else {
                            echo 'Save Image Errors: ';
                            var_dump($image->getErrors());
                            echo "\n";
                            if ($image2 = Image::find()->where(['file_basename' => $image->file_basename])->one()) {
                                echo "An image with same base_filename was found: $image2->file_basename\n";
                                $article->image_id = $image2->id;
                            }
                        }
                    } catch (\Exception $e) {
                        $errors[] = $e->getMessage();
                        echo "Cannot get image content\n";
                    }
                    $image = null;
                    $image2 = null;
                    $meta_ogImage = null;
                }
                if ($article->save()) {
                    $new_article_count++;
                    echo $this->stdout("Saved Article#$article->id successfully\n", Console::FG_GREEN);
                } else {
                    echo 'Article Errors: ';
                    var_dump($article->getErrors());
                    echo "\n";
                }
                $article = null;
                $dom = null;
                $h1 = null;
                $content = null;

            } catch (\Exception $e) {
                $errors[] = [$crawler->url, $e->getMessage()];
            }

            // Echo memory usage
            $mem = date('H:i:s') . ' Current memory usage: ' . (memory_get_usage(true) / 1024 / 1024) . " MB\n";
            // Echo memory peak usage
            $mem .= date('H:i:s') . " Peak memory usage: " . (memory_get_peak_usage(true) / 1024 / 1024) . " MB\n";
            echo $mem;
        }
        echo "\n===========================\n";
        echo "New Articles: $new_article_count\n";
        echo "New Images: $new_image_count\n";
        echo "Errors:\n";
        var_dump($errors);

    }

    public function actionArticle()
    {
        ini_set('memory_limit', '1024M');
        $i = 0;
        $k = 0;
        $data = CrawledPage::find()->offset(0)->limit(3000)->all();
//        foreach ($data as $key => $item) {
//            echo "$key\n";
//        }
//        return;
        foreach ($data as $key => $item) {
            echo "$item->url\n";
            if (in_array($item->url, [
                'http://tiengtrunganhduong.com/1226/tnd/doi-ngu-giao-vien.htm',
                'http://tiengtrunganhduong.com/trung-tam-tieng-trung-Anh-Duong.htm',
                'http://tiengtrunganhduong.com/bang-chu-cai-tieng-trung.htm',
                'http://tiengtrunganhduong.com/250-tu-vung-tieng-trung-chu-de-thu-vien.htm',
                'http://tiengtrunganhduong.com/bo-quan-ao-nay-hop-voi-toi-khong.htm',
                'http://tiengtrunganhduong.com/dich-ho-ten-tieng-viet-sang-tieng-trung.htm',
                'http://tiengtrunganhduong.com/cong-viec-hang-ngay.htm',
            ])) {
                echo "Locked list\n";
                continue;
            }
            $k++;
//            if ($i > 9) {
//                break;
//            }
            $html = "<html>" . $item->content . "</html>";
            $dom = new Dom;
            echo 1;
            $dom->loadStr($html, [
                'whitespaceTextNode' => true,
                'strict'             => false,
                'enforceEncoding'    => null,
                'cleanupInput'       => false,
                'removeScripts'      => false,
                'removeStyles'       => false,
                'preserveLineBreaks' => true,
            ]);
            $relative_url = str_replace('http://tiengtrunganhduong.com/', '', $item->url);
            $h1 = $dom->find('h1.nameOtherNew', 0);
            $content = $dom->find('div.contentNewTop', 0);
            echo 2 . "\n";
//            var_dump($k, $h1, $content);
            if ($h1 && $content && substr($relative_url, -4) === '.htm' && strpos($relative_url, '/') === false) {
                if ($article = Article::find()
                    ->where(['slug' => $relative_url])
                    ->orWhere(['slug' => str_replace('.htm', '', $relative_url)])->one()) {
//                    if ($time_div = $dom->find('div.timeNewTop', 0)) {
//                        $view_count = (int) str_replace(['lượt xem', '-', ' '], '', substr($time_div->innerHTML, 11));
//                        $article->view_count = $view_count;
//                        $article->active = 1;
//                        $article->visible = 1;
//                        if ($article->save()) {
//                            echo 'Update view_count for article id = ' . $article->id . ' ' . $time_div->innerHTML . ';' . str_replace(['lượt xem', '-', ' '], '', substr($time_div->innerHTML, 11)) . '; ' . $view_count . "\n";
//                        } else {
//                            echo 'Update view_count errors:';
//                            var_dump($article->getErrors());
//                        }
//                        $time_div = null;
//                    }
//                    if ($linkRoad = $dom->find('a.linkRoad', 2)) {
//                        $catName = $linkRoad->innerHTML;
//                        if ($category = ArticleCategory::findOne(['name' => $catName])) {
//                            echo $category->name . "\n";
//                            $article->category_id = $category->id;
//                            $article->slug = str_replace('.htm', '', $article->slug);
//                            if ($article->save()) {
//                                echo '... ' . $article->name . "\n";
//                            }
//                            $category = null;
//                        }
//                        $linkRoad = null;
//                    }
                    echo "article id = $article->id\n";
                    if ($article->id < 21) {
                        if (strpos($article->slug, '.htm') !== false) {
                            $article->slug = str_replace('.htm', '', $relative_url);
                        }
                        $article->content = $content->innerHTML;
                        if ($article->save()) {
                            echo $article->id . "\n";
                        } else {
                            var_dump($article->errors);
                        }
                    }
                    $article = null;
                    continue;
                }
                continue;
                $article = new Article();
                $article->name = $article->meta_title = $h1->innerHTML;
                $article->content = $content->innerHTML;
                $article->slug = $relative_url;
                $article->active = 1;
                $article->visible = 1;
                if ($time_div = $dom->find('div.timeNewTop', 0)) {
                    $time = strtotime(str_replace('/', '-', substr($time_div->innerHTML, 0, 10)));
                    $view_count = (int) str_replace(['lượt xem', '-', ' '], '', substr($time_div->innerHTML, 11));
                    $article->create_time = $article->update_time = $article->publish_time = $time;
                    $article->view_count = $view_count;
                    $time_div = null;
                }
                if ($meta_keywords = $dom->find('meta[name="keywords"]', 0)) {
                    $article->meta_keywords = $meta_keywords->getAttribute('content');
                    $meta_keywords = null;
                }
                if ($meta_description = $dom->find('meta[name="description"]', 0)) {
                    $article->description = $article->meta_description = $meta_description->getAttribute('content');
                    $meta_description = null;
                }
                if ($meta_ogImage = $dom->find('meta[property="og:image"]', 0)) {
                    $image_source = $meta_ogImage->getAttribute('content');
                    $image = new Image();
                    $image->image_source = $image_source;
                    $image->name = $article->name;
                    $image->create_time = $article->create_time;
                    $image->update_time = $article->update_time;
                    $image->active = 1;
                    if ($image->saveFileAndModel()) {
                        if ($image->save()) {
                            $article->image_id = $image->id;
                            echo $image->getSource() . "\n";
                        } else {
                            echo 'Image Errors: ';
                            var_dump($image->getErrors());
                            echo "\n";
                        }
                    } else {
                        echo 'Save Image Errors: ';
                        var_dump($image->getErrors());
                        echo "\n";
                        if ($image2 = Image::find()->where(['file_basename' => $image->file_basename])->one()) {
                            $article->image_id = $image2->id;
                        }
                    }
                    $image = null;
                    $image2 = null;
                    $meta_ogImage = null;
                }

                if ($article->save()) {
                    $i++;
                    echo $article->id . '. ' . $article->slug . "\n\n";
                } else {
                    echo 'Article Errors: '; var_dump($article->getErrors());
                }
                
                $article = null;
            } else {
                echo "Do not pass\n";
            }
            $dom = null;
            $h1 = null;
            $content = null;
        }
    }

    public function actionUpdateCategories()
    {
        foreach (ArticleCategory::find()->all() as $item) {
//            $item->active = $item->visible = 1;
            $item->meta_title = $item->meta_description = $item->meta_keywords = $item->name;
            if ($item->save()) {
                echo $item->name . "\n";
            }
        }
    }

    public function actionArticleCategory()
    {
        $json_news = '[{"parent":"SẮC MÀU TRUNG HOA","children":["Lịch sử và văn hóa","Âm nhạc","Xã Hội","Bài thuốc"]},{"parent":"VỀ CHÚNG TÔI","children":["Sự khác biệt","Quyền lợi của học viên","Cảm nhận của học viên","Video-Hình ảnh lớp học"]},{"parent":"CHIA SẺ KINH NGHIỆM","children":["Phương pháp học","Du học"]},{"parent":"GÓC HỌC TẬP","children":["Video, mp3","Thi HSK","Dịch thuật","Từ vựng theo chủ đề","Khẩu ngữ giao tiếp","Ngữ pháp","Học tiếng Trung qua hình ảnh","Tiếng Trung bồi"]},{"parent":"HOẠT ĐỘNG NGOẠI KHÓA","children":["Câu lạc bộ hán ngữ","Giao lưu, du lịch"]},{"parent":"GIẢI TRÍ","children":["Clip hài, truyện cười","Ca khúc tiếng Hoa","Người nổi tiếng","Ẩm thực"]},{"parent":"TÀI LIỆU","children":["Sách hay","Phát âm và chữ viết","Ngữ pháp và từ vựng","Phần mềm học tiếng Trung"]}]';
        $json_services = '[{"parent":"CÁC KHÓA HỌC VÀ HỌC PHÍ","children":[]},{"parent":"LỊCH KHAI GIẢNG","children":[]},{"parent":"CÁC LỚP ĐANG HỌC","children":[]},{"parent":"HƯỚNG DẪN ĐĂNG KÝ HỌC","children":[]},{"parent":"KHUYẾN MẠI","children":[]}]';
        $news = json_decode($json_news, true);
        $services = json_decode($json_services, true);
        foreach ($services as $item) {
            $category = new ArticleCategory();
            $category->name = $item['parent'];
            $category->slug = Inflector::slug(MyStringHelper::stripUnicode($category->name));
            $category->type = 2;
            if ($category->save()) {
                echo '...' . $category->name . "\n";
                foreach ($item['children'] as $child) {
                    $cat = new ArticleCategory();
                    $cat->name = $child;
                    $cat->slug = Inflector::slug(MyStringHelper::stripUnicode($cat->name));
                    $cat->parent_id = $category->id;
                    $cat->type = 2;
                    if ($cat->save()) {
                        echo '......' . $cat->name . "\n";
                    } else {
                        var_dump($cat->errors);
                        echo "\n";
                    }
                }
            } else {
                var_dump($category->errors);
                echo "\n";
            }
        }
    }

//    public function actionArticleImages()
//    {
//        foreach (Article::find()->limit(20)->orderBy('id asc')->all() as $article) {
//            $dom = new Dom;
//            echo '...';
//            $dom->loadStr($article->content, [
//                'whitespaceTextNode' => true,
//                'strict'             => false,
//                'enforceEncoding'    => null,
//                'cleanupInput'       => false,
//                'removeScripts'      => false,
//                'removeStyles'       => false,
//                'preserveLineBreaks' => true,
//            ]);
//            foreach ($dom->find('img') as $img) {
//                $image = new Image();
//                $image->image_source = $img->getAttribute('src');
//                if (strpos($image->image_source, 'http') === false) {
//                    $image->image_source = 'http://tiengtrunganhduong.com' . $image->image_source;
//                }
//                $image->name = $article->name;
//                $image->create_time = $article->create_time;
//                $image->update_time = $article->update_time;
//                $image->active = 1;
//                if ($image->saveFileAndModel()) {
//                    if ($image->save()) {
//                        echo $image->getSource() . "\n";
//                        $img->setAttribute('src', $image->getSource());
//                        $img->setAttribute('data-id', $image->id);
//                    } else {
//                        echo 'Image Errors: ';
//                        var_dump($image->getErrors());
//                        echo "\n";
//                    }
//                } else {
//                    echo 'Save Image Errors: ';
//                    var_dump($image->getErrors());
//                    echo "\n";
//                    if ($image2 = Image::find()->where(['file_basename' => $image->file_basename])->one()) {
//                        echo 'Found Same Image: ';
//                        echo $image2->getSource() . "\n";
//                        $img->setAttribute('src', $image2->getSource());
//                        $img->setAttribute('data-id', $image2->id);
//                    }
//                }
//                $dom->saveHTML();
//                $image = null;
//                $image2 = null;
//                $meta_ogImage = null;
//            }
//            if ($article->save()) {
//                echo $article->id . "\n";
//            }
//        }
//    }

    public function actionArticleImages()
    {
        libxml_use_internal_errors(true);
        foreach (Article::find()->limit(3000)->offset(50)->orderBy('id asc')->all() as $article) {
            $doc = new \DOMDocument();
            $doc->loadHTML($article->content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            foreach ($doc->getElementsByTagName("img") as $img) {
                $image = new Image();
                $image->image_source = $img->getAttribute('src');
                if (strpos($image->image_source, 'http') === false) {
                    $image->image_source = 'http://tiengtrunganhduong.com' . $image->image_source;
                }
                $image->name = $article->name;
                $image->create_time = $article->create_time;
                $image->update_time = $article->update_time;
                $image->active = 1;
                if ($image->saveFileAndModel()) {
                    if ($image->save()) {
                        echo $image->getSource() . "\n";
                        $img->setAttribute('src', $image->getSource());
                        $img->setAttribute('data-id', $image->id);
                    } else {
                        echo 'Image Errors: ';
                        var_dump($image->getErrors());
                        echo "\n";
                    }
                } else {
                    echo 'Save Image Errors: ';
                    var_dump($image->getErrors());
                    echo "\n";
                    if ($image2 = Image::find()->where(['file_basename' => $image->file_basename])->one()) {
                        echo 'Found Same Image: ';
                        echo $image2->getSource() . "\n";
                        $img->setAttribute('src', $image2->getSource());
                        $img->setAttribute('data-id', $image2->id);
                    }
                }
                $image = null;
                $image2 = null;
                $meta_ogImage = null;
                $article->sub_content = $doc->saveHTML();
            }
            if ($article->save()) {
                echo $article->id . "\n";
            }
        }
    }

    public function actionUpdateImages()
    {
        /**
         * @var Image[] $images
         */
        $images = Image::find()->offset($this->offset)->limit($this->limit)->all();
        $errors = [];
        $total = count($images);
        $successes = 0;
        foreach ($images as $i => $image) {
            echo "\n-----------[ $i ]-----------/$total\n";
            echo "From: $image->file_basename\n";

//            if ($image->file_basename === Inflector::slug(MyStringHelper::stripUnicode($image->name))) {
//                echo "To  : Okay!\n";
//                continue;
//            }

            if (!$image->quality) {
                $image->quality = 50;
            }

            $image->image_resize_labels = [
                Image::SIZE_1,
                Image::SIZE_2,
                Image::SIZE_3,
                Image::SIZE_4,
                Image::SIZE_5,
                Image::SIZE_6,
                Image::SIZE_7,
                Image::SIZE_8,
                Image::SIZE_9,
            ];

            $image->file_basename = Inflector::slug(MyStringHelper::stripUnicode($image->name));

            $k = '';
            $j = 1;
            while (Image::find()
                ->where(['!=', 'id', $image->id])
                ->andWhere(['file_basename' => $image->file_basename . "$k", ])
                ->one()
            ) {
                $j++;
                $k = "--$j";
            }

            $image->file_basename .= "$k";

            if ($image->updateFileAndModel()) {
                echo "To  : $image->file_basename\n";
                echo "RS  : $image->resize_labels\n";
                $successes++;
            } else {
                $errors_msg = VarDumper::dumpAsString($image->getErrors());
                $errors[] = [$image->id, $image->file_basename, $errors_msg];
                echo "Errors: $errors_msg\n";
            }
        }
        echo "\n==============================\n";
        echo "Successes: $successes / $total\n";
        echo "Errors:\n";
        var_dump($errors);
        echo "\n";
    }
}