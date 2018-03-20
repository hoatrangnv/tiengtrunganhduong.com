<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "contact".
 *
 * @property integer $id
 * @property integer $updater_id
 * @property integer $creator_id
 * @property string $name
 * @property string $email
 * @property string $phone_number
 * @property string $subject
 * @property string $body
 * @property integer $type
 * @property integer $status
 * @property integer $create_time
 * @property integer $update_time
 *
 * @property User $creator
 * @property User $updater
 */
class Contact extends \common\models\MyActiveRecord
{
    const STATUS_NEW = 1;
    const STATUS_SEEN = 2;
    const STATUS_REPLIED = 3;

    const TYPE_NORMAL = 1;
    const TYPE_COURSE_REGISTRATION = 2;

    public static function getStatuses()
    {
        return [
            self::STATUS_NEW => Yii::t('app', 'New'),
            self::STATUS_SEEN => Yii::t('app', 'Seen'),
            self::STATUS_REPLIED => Yii::t('app', 'Replied'),
        ];
    }

    public static function getTypes()
    {
        return [
            self::TYPE_NORMAL => 'Normal',
            self::TYPE_COURSE_REGISTRATION => 'Course Registration'
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
        return 'contact';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[/*'creator_id', 'updater_id',*/ 'type', 'status', /*'create_time', 'update_time'*/], 'integer'],
            [['body'], 'string'],
            [['phone_number'], 'string', 'max' => 32],
            [['name', 'email', 'subject'], 'string', 'max' => 255],
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
            'email' => 'Email',
            'subject' => 'Subject',
            'body' => 'Body',
            'type' => 'Type',
            'status' => 'Status',
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
