<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "url_redirection".
 *
 * @property integer $id
 * @property integer $creator_id
 * @property integer $updater_id
 * @property string $from_url
 * @property string $to_url
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
class UrlRedirection extends MyActiveRecord
{
    const TYPE_EQUALS = 1;
    const TYPE_CONTAINS = 2;
    const TYPE_STARTS_WITH = 3;
    const TYPE_ENDS_WITH = 4;
    const TYPE_REGEXP = 5;

    public static function getTypes()
    {
        return [
            self::TYPE_EQUALS => Yii::t('app', 'Equals'),
            self::TYPE_CONTAINS => Yii::t('app', 'Contains'),
            self::TYPE_STARTS_WITH => Yii::t('app', 'Starts with'),
            self::TYPE_ENDS_WITH => Yii::t('app', 'Ends with'),
            self::TYPE_REGEXP => Yii::t('app', 'Regular Expression'),
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
        return 'url_redirection';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[/*'creator_id', 'updater_id',*/ 'active', 'type', 'status', 'sort_order',
                /*'create_time', 'update_time'*/], 'integer'],
            [['from_url', 'to_url'], 'required'],
            [['from_url', 'to_url'], 'string', 'max' => 255],
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
            'from_url' => 'From Url',
            'to_url' => 'To Url',
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
