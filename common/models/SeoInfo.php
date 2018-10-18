<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "seo_info".
 *
 * @property integer $id
 * @property integer $creator_id
 * @property integer $updater_id
 * @property integer $image_id
 * @property string $url
 * @property string $route
 * @property string $name
 * @property string $meta_title
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $description
 * @property string $long_description
 * @property string $content
 * @property integer $active
 * @property integer $type
 * @property integer $status
 * @property integer $sort_order
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $doindex
 * @property integer $dofollow
 * @property integer $disable_ads
 *
 * @property User $creator
 * @property User $updater
 * @property Image $image
 */
class SeoInfo extends MyActiveRecord
{
    public static function getRoutes()
    {
        return [
            'site/index' => Yii::t('app', 'Homepage'),
            'site/contact' => Yii::t('app', 'Contact'),
            'article/index' => Yii::t('app', 'News'),
            'article/tags' => Yii::t('app', 'News Tags'),
            'article/search' => Yii::t('app', 'News Search'),
            'name-translation/index' => Yii::t('app', 'Name Translation'),
        ];
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
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'seo_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[/*'creator_id', 'updater_id',*/ 'image_id', 'active', 'type', 'status', 'sort_order',
                /*'create_time', 'update_time',*/ 'doindex', 'dofollow', 'disable_ads'], 'integer'],
            [['name'], 'required'],
            [['long_description', 'content'], 'string'],
            [['url', 'meta_keywords', 'meta_description', 'description'], 'string', 'max' => 511],
            [['route', 'name', 'meta_title'], 'string', 'max' => 255],
//            [['creator_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creator_id' => 'id']],
//            [['updater_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updater_id' => 'id']],
            [['image_id'], 'exist', 'skipOnError' => true, 'targetClass' => Image::className(), 'targetAttribute' => ['image_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'creator_id' => 'Creator ID',
            'updater_id' => 'Updater ID',
            'image_id' => 'Image ID',
            'url' => 'Url',
            'route' => 'Route',
            'name' => 'Name',
            'meta_title' => 'Meta Title',
            'meta_keywords' => 'Meta Keywords',
            'meta_description' => 'Meta Description',
            'description' => 'Description',
            'long_description' => 'Long Description',
            'content' => 'Content',
            'active' => 'Active',
            'type' => 'Type',
            'status' => 'Status',
            'sort_order' => 'Sort Order',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'doindex' => 'Doindex',
            'dofollow' => 'Dofollow',
            'disable_ads' => 'Disable Ads',
        ];
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
}
