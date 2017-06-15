<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 6/9/2017
 * Time: 8:50 PM
 */

namespace console\controllers;


use backend\models\Image;
use frontend\models\ArticleCategory;
use yii\console\Controller;
use yii\helpers\VarDumper;

class UpdateController extends Controller
{
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

}