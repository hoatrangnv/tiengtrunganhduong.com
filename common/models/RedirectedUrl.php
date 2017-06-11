<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "redirected_url".
 *
 * @property integer $id
 * @property integer $creator_id
 * @property integer $updater_id
 * @property string $from_urls
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
class RedirectedUrl extends MyActiveRecord
{
    public function getUrl($params = [])
    {
        // TODO: Implement getUrl() method.
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'redirected_url';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['creator_id', 'updater_id', 'active', 'type', 'status', 'sort_order', 'create_time', 'update_time'], 'integer'],
            [['from_urls', 'to_url'], 'required'],
            [['from_urls'], 'string'],
            [['to_url'], 'string', 'max' => 255],
            [['creator_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creator_id' => 'id']],
            [['updater_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updater_id' => 'id']],
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
            'from_urls' => 'From Urls',
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
