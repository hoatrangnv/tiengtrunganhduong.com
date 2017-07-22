<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "site_param".
 *
 * @property integer $id
 * @property integer $creator_id
 * @property integer $updater_id
 * @property string $name
 * @property string $value
 * @property integer $active
 * @property integer $type
 * @property integer $status
 * @property integer $sort_order
 * @property integer $create_time
 * @property integer $update_time
 *
 * @property User $creator
 * @property User $updater
 */
class SiteParam extends MyActiveRecord
{
    const FACEBOOK_URL = 'facebook_url';
    const GOOGLE_PLUS_URL = 'google_plus_url';
    const TWITTER_URL = 'twitter_url';
    const YOUTUBE_URL = 'youtube_url';
    const ADDRESS = 'address';
    const EMAIL = 'email';
    const PHONE_NUMBER = 'phone_number';
    const COMPANY_NAME = 'company_name';

    public static function getTypes()
    {
        return [
            self::FACEBOOK_URL => 'Facebook URL',
            self::GOOGLE_PLUS_URL => 'Google plus URL',
            self::TWITTER_URL => 'Twitter URL',
            self::YOUTUBE_URL => 'Youtube URL',
            self::COMPANY_NAME => 'Company name',
            self::PHONE_NUMBER => 'Phone number',
            self::EMAIL => 'Email',
            self::ADDRESS => 'Address',
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
        return 'site_param';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[/*'creator_id', 'updater_id',*/ 'active', 'type', 'status', 'sort_order',
                /*'create_time', 'update_time'*/], 'integer'],
            [['name', 'value'], 'required'],
            [['value'], 'string'],
            [['name'], 'string', 'max' => 255],
//            [['creator_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creator_id' => 'id']],
//            [['updater_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updater_id' => 'id']],
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
            'name' => 'Name',
            'value' => 'Value',
            'active' => 'Active',
            'type' => 'Type',
            'status' => 'Status',
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
}
