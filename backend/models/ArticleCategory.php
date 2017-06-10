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
        return self::_dropDownListData_recursive(self::find()->where(['parent_id' => null])->all());
    }

    /**
     * @param self[] $categories
     * @return array
     */
    private static function _dropDownListData_recursive($categories)
    {
        $result = [];
        foreach ($categories as $category) {
            $children = $category->getArticleCategories()->all();
            if ($children) {
                $result[$category->name] = [
                    $category->id => $category->name,
                    '__________' => self::_dropDownListData_recursive($children),
                ];
            } else {
                $result[$category->id] = $category->name;
            }
        }
        return $result;
    }
}