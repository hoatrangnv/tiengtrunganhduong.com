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
use console\models\CrawledPage;
use yii\console\Controller;
use PHPHtmlParser\Dom;
use yii\helpers\Inflector;

class CrawlController extends Controller
{
    public static $sitemap_filename;

    public function beforeAction($action)
    {
        self::$sitemap_filename = __DIR__ . '/../data/sitemap.xml';
        return parent::beforeAction($action); // TODO: Change the autogenerated stub
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

    public function actionArticle()
    {
        ini_set('memory_limit', '1024M');
        $i = 0;
        $k = 0;
        $data = CrawledPage::find()->offset(2)->limit(100)->all();
//        foreach ($data as $key => $item) {
//            echo "$key\n";
//        }
//        return;
        foreach ($data as $key => $item) {
            echo "$item->url\n";
            $k++;
//            if ($i > 9) {
//                break;
//            }
            $html = "<html>" . $item->content . "</html>";
            $dom = new Dom;
            echo 1;
            $dom->load($html);
            $h1 = $dom->find('h1.nameOtherNew', 0);
            $content = $dom->find('div.contentNewTop', 0);
            echo 2 . "\n";
//            var_dump($k, $h1, $content);
            $relative_url = str_replace('http://tiengtrunganhduong.com/', '', $item->url);
            if ($h1 && $content && substr($relative_url, -4) === '.htm' && strpos($relative_url, '/') === false) {
                $article = new Article();
                $article->name = $article->meta_title = $h1->innerHTML;
                $article->content = $content->innerHTML;
//                $article->slug = Inflector::slug(MyStringHelper::stripUnicode($article->name));
                $article->slug = $relative_url;
                if ($meta_keywords = $dom->find('meta[name="keywords"]', 0)) {
                    $article->meta_keywords = $meta_keywords->getAttribute('content');
                    $meta_keywords = null;
                }
                if ($meta_description = $dom->find('meta[name="description"]', 0)) {
                    $article->description = $article->meta_description = $meta_description->getAttribute('content');
                    $meta_description = null;
                }
                if ($meta_ogImage = $dom->find('meta[name="og:image"]', 0)) {
                    $image_source = $meta_ogImage->getAttribute('content');
                    $image = new Image();
                    $image->image_source = $image_source;
                    if ($image->saveFile()) {
                        $image->active = 1;
                        if ($image->save()) {
                            $article->image_id = $image->id;
                            echo $image->getSource() . "\n";
                        } else {
                            echo 'Image Errors: '; var_dump($image->getErrors());
                        }
                    }
                    $image = null;
                    $meta_ogImage = null;
                }

                if ($article->save()) {
                    $i++;
                    echo $i . '. ' . $article->slug . "\n\n";
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
}