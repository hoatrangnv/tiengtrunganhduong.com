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

class UpdateController extends Controller
{
    public function actionArticleCategories()
    {
        foreach (ArticleCategory::find()->where(['parent_id' => null])->all() as $category) {
//            if ($category->type == ArticleCategory::TYPE_SERVICE) {
//                $category->parent_id = 41;
//                if ($category->save()) {
//                    echo $category->name . "\n";
//                } else {
//                    var_dump($category->getErrors());
//                }
//            }
            if ($category->featured == 1) {
                foreach ($category->findChildren() as $child) {
                    $child->featured = 1;
                    if ($child->save()) {
                        echo $child->name . "\n";
                    }
                }
            }
        }
    }

    public function actionImages()
    {
        /**
         * @var Image $item
         */
        $successes = 0;
        $total = 0;
        foreach (Image::find()->all() as $item) {
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