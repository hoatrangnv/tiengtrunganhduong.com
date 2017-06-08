<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "banner".
 *
 * @property integer $id
 * @property integer $creator_id
 * @property integer $updater_id
 * @property integer $image_id
 * @property string $name
 * @property string $link
 * @property string $caption
 * @property integer $active
 * @property integer $type
 * @property integer $sort_order
 * @property integer $create_time
 * @property integer $update_time
 *
 * @property User $creator
 * @property User $updater
 * @property Image $image
 */
class Banner extends \common\models\MyActiveRecord
{
    public function getUrl($params = [])
    {
        // TODO: Implement getUrl() method.
        return $this->link;
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
        return 'banner';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[/*'creator_id', 'updater_id',*/ 'image_id', 'active', 'type', 'sort_order',
                /*'create_time', 'update_time'*/], 'integer'],
            [['name'], 'required'],
            [['name', 'link', 'caption'], 'string', 'max' => 255],
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
            'name' => 'Name',
            'link' => 'Link',
            'caption' => 'Caption',
            'active' => 'Active',
            'type' => 'Type',
            'sort_order' => 'Sort Order',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
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
