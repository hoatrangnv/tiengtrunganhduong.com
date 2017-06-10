<?php
/**
 * Created by PhpStorm.
 * User: Quyet
 * Date: 6/6/2017
 * Time: 9:01 AM
 */

namespace backend\models;


use yii\helpers\ArrayHelper;

class ArticleCategory extends \common\models\ArticleCategory
{
    /**
     * @return array
     */
    public static function dropDownListData()
    {
        /**
         * @param self[] $categories
         * @return array
         */
        $arrange = function ($categories) use (&$arrange) {
            $result = [];
            foreach ($categories as $category) {
                $children = $category->getArticleCategories()->all();
                if ($children) {
                    $result[$category->name] = [
                        $category->id => $category->name,
                        '__________' => $arrange($children),
                    ];
                } else {
                    $result[$category->id] = $category->name;
                }
            }
            return $result;
        };

        return $arrange(self::find()->where(['parent_id' => null])->all());
    }

}