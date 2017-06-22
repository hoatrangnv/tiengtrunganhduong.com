<?php
/**
 * Created by PhpStorm.
 * User: Quyet
 * Date: 6/6/2017
 * Time: 9:01 AM
 */

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

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
         * @param bool $isRoot
         * @return array
         */
        $arrange = function ($categories, $isRoot = true) use (&$arrange) {
            $result = [];
            foreach ($categories as $category) {
                $children = $category->getArticleCategories()->all();
                if (!empty($children)) {
                    $result[$category->name] = [
                        "$category->id" => $category->name,
                        '__________' => $arrange($children, false),
                        '' => '',
                    ];
                } else {
                    if ($isRoot) {
                        $result['(No Children)']["$category->id"] = $category->name;
                    } else {
                        $result["$category->id"] = $category->name;
                    }
                }
            }
            return $result;
        };

        $result = array_merge(
            [0 => Yii::t('yii', '(not set)'),
            $arrange(self::find()->where(['parent_id' => null])->all())]
        );
        return $result;
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

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'creator_id',
                'updatedByAttribute' => 'updater_id',
            ],
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'create_time',
                'updatedAtAttribute' => 'update_time',
                'value' => time(),
            ],
//            [
//                'class' => MySluggableBehavior::className(),
//                'attribute' => 'name',
//                'slugAttribute' => 'slug',
//                'immutable' => false,
//                'ensureUnique' => true,
//            ],
        ];
    }
}