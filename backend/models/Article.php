<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 3/31/2017
 * Time: 12:30 AM
 */

namespace backend\models;

use yii\helpers\Url;

/**
 * Class Article
 * @package backend\models
 *
 * @property User $creator
 * @property User $updater
 * @property Image $image
 * @property ArticleCategory $category
 *
 */

class Article extends \common\models\Article
{
    public function getUrl($params = [])
    {
        // TODO: Implement getUrl() method.
        return Url::to(array_merge(['article/update', 'id' => $this->id], $params), true);
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
    public function getCategory()
    {
        return $this->hasOne(ArticleCategory::className(), ['id' => 'category_id']);
    }
}