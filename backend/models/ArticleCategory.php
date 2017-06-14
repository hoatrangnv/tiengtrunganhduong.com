<?php
/**
 * Created by PhpStorm.
 * User: Quyet
 * Date: 6/6/2017
 * Time: 9:01 AM
 */

namespace backend\models;


use yii\helpers\ArrayHelper;

/**
 * Class ArticleCategory
 * @package backend\models
 *
 * @property Article[] $articles
 * @property User $creator
 * @property User $updater
 * @property Image $image
 * @property ArticleCategory $parent
 * @property ArticleCategory[] $articleCategories
 *
 */

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

        return array_merge(
            [-1 => '(Không có)'],
            $arrange(self::find()->where(['parent_id' => null])->all())
        );
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(Article::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreator()
    {
        return $this->hasOne(User::className(), ['id' => 'creator_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdater()
    {
        return $this->hasOne(User::className(), ['id' => 'updater_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'image_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(ArticleCategory::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticleCategories()
    {
        return $this->hasMany(ArticleCategory::className(), ['parent_id' => 'id']);
    }

}