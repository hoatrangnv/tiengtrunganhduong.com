<?php

namespace console\models;

use Yii;

/**
 * This is the model class for table "crawler".
 *
 * @property integer $id
 * @property string $url
 * @property string $type
 * @property string $status
 * @property string $content
 * @property string $error_message
 * @property string $time
 */
class Crawler extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'crawler';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['url'], 'required'],
            [['content', 'error_message'], 'string'],
            [['time'], 'safe'],
            [['type', 'status'], 'string', 'max' => 255],
            [['url'], 'string', 'max' => 1023],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'Url',
            'type' => 'Type',
            'status' => 'Status',
            'content' => 'Content',
            'error_message' => 'Error Message',
            'time' => 'Time',
        ];
    }
}
