<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 6/9/2017
 * Time: 8:50 PM
 */

namespace console\controllers;


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
}