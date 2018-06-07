<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 6/9/2017
 * Time: 8:50 PM
 */

namespace console\controllers;


use backend\models\Image;
use common\models\NameTranslation;
use frontend\models\ArticleCategory;
use yii\console\Controller;
use yii\helpers\VarDumper;
use common\helpers\MyStringHelper;
use common\models\Article;
use console\models\CrawledPage;
use common\models\Crawler;
use PHPHtmlParser\Dom;
use yii\helpers\Console;
use yii\helpers\Inflector;


class UpdateController extends Controller
{
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

    public function actionArticleCategories()
    {
        foreach (ArticleCategory::find()->all() as $category) {
//            if ($category->type == ArticleCategory::TYPE_SERVICE) {
//                $category->parent_id = 41;
//                if ($category->save()) {
//                    echo $category->name . "\n";
//                } else {
//                    var_dump($category->getErrors());
//                }
//            }
//            if ($category->featured == 1) {
//                foreach ($category->findChildren() as $child) {
//                    $child->featured = 1;
//                    if ($child->save()) {
//                        echo $child->name . "\n";
//                    }
//                }
//            }
            $category->shown_on_menu = $category->featured;
            if ($category->save()) {
                echo $category->name . "\n";
            } else {
                echo VarDumper::dumpAsString($category->errors) . "\n";
            }
        }
    }

    public function actionImages()
    {
        ini_set('memory_limit', '1024M');
        /**
         * @var Image $item
         */
        $successes = 0;
        $total = 0;
        foreach (Image::find()->limit(1000)->offset(1000)->all() as $item) {
            $total++;
            try {
                list($item->width, $item->height) = getimagesize($item->getLocation());
                $item->calculateAspectRatio();
                $item->quality = 50;
                if ($item->save()) {
                    $successes++;
                    echo $item->name . "\n";
                } else {
                    var_dump($item->getErrors());
                    echo "\n";
                }
            } catch (\Exception $e) {
                echo $e->getMessage() . "\n";
            }
        }
        echo "\nTotal: $total; Success: $successes\n";
    }

    public function actionCrawlers()
    {
        ini_set('memory_limit', '1024M');

        /**
         * @var Crawler[] $crawlers
         */
        $crawlers = Crawler::find()
//            ->where(['!=', 'content', ''])
            ->andWhere(['not like', 'url', 'http://m.tiengtrunganhduong.com%'])
            ->andWhere(['=', 'target_model_type', Crawler::TARGET_MODEL_TYPE__ARTICLE_CATEGORY])
            ->andWhere(['or', ['=', 'target_model_slug', 'search'], ['=', 'target_model_slug', 'tags']])
            ->offset($this->offset)
            ->limit($this->limit)
            ->all();
        $total = count($crawlers);
        $article_type_num = 0;
        $errors = [];
//        if (false)
        foreach ($crawlers as $i => $crawler) {

            echo "\n------------[ $i ]------------/$total\n";
            echo $crawler->url . "\n";

            $url_path = parse_url($crawler->url, PHP_URL_PATH);
            $url_slugs = explode('/', $url_path);
            $last_slug = $url_slugs[count($url_slugs) - 1];
            if (substr($last_slug, -4) !== '.htm') {
                continue;
            }

            $slug = strtolower(substr($last_slug, 0, -4));
            echo "Slug: $slug\n";

            try {
//                $dom = new Dom();
//                $dom->loadStr($crawler->content, [
//                    'whitespaceTextNode' => true,
//                    'strict' => false,
//                    'enforceEncoding' => null,
//                    'cleanupInput' => false,
//                    'removeScripts' => false,
//                    'removeStyles' => false,
//                    'preserveLineBreaks' => true,
//                ]);
//                $h1 = $dom->find('.nameNew, .nameNewTop, .descNew, .descNewTop', 0);
//                $content = $dom->find('.timeNew, .timeNewTop', 0);
//                if (!$h1 || !$content) {
//                    echo "There is no .nameNew(Top) or .timeNew(Top) or content was found\n";
//                    continue;
//                }
                $crawler->target_model_type = null;
                $crawler->target_model_slug = null;
//                $crawler->target_model_type = Crawler::TARGET_MODEL_TYPE__ARTICLE_CATEGORY;
//                $crawler->target_model_slug = $slug;
//
                if ($crawler->save()) {
                    $article_type_num++;
                    echo $this->stdout("Save crawler of Category Article slug = $slug", Console::FG_GREEN);
                    echo "\n";
                } else {
                    echo $crawler->getErrors() . "\n";
                    $errors[] = $crawler->getErrors();
                }

            } catch (\Exception $exception) {
                echo $exception->getMessage() . "\n";
                $errors[] = $exception->getMessage();
            }
        }
        echo "\n==============================\n";
        echo "Article Categories: $article_type_num / $total\n";
        echo "Errors:\n";
        var_dump($errors);
        echo "\n";
    }

    public function actionImageResize()
    {
        /**
         * @var Image $item
         */
        foreach (Image::find()->all() as $item) {
            $resize_labels = json_decode($item->resize_labels, true);
            if (!is_array($resize_labels)) {
                continue;
            }
            $new_resize_labels = [];
            foreach ($resize_labels as $resize_label) {
                $new_resize_labels[str_replace('-', '', $resize_label)] = $resize_label;
            }
            $item->resize_labels = json_encode($new_resize_labels);
            if ($item->save()) {
                echo $item->resize_labels . "\n";
            } else {
                echo VarDumper::dumpAsString($item->errors) . "\n";
            }
        }
    }

    public function actionRemoveSpacesFromNameTranslationTable()
    {
        $w_count = 0;
        $s_count = 0;
        foreach (NameTranslation::find()->where(['type' => NameTranslation::TYPE_FIRST_NAME])->all() as $nameTranslation) {
            /**
             * @var $nameTranslation NameTranslation
             */
            if (strpos($nameTranslation->translated_word, ' ') !== false) {
                $w_count++;
            }
            if (strpos($nameTranslation->spelling, ' ') !== false) {
                $s_count++;
            }
        }
        echo "\nW count = $w_count";
        echo "\nS count = $s_count";
    }
}