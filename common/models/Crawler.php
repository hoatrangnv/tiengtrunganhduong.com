<?php

namespace common\models;

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
 * @property integer $target_model_type
 * @property string $target_model_slug
 */
class Crawler extends \common\models\MyActiveRecord
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
            [['target_model_type'], 'integer'],
            [['url'], 'string', 'max' => 1023],
            [['type', 'status', 'target_model_slug'], 'string', 'max' => 255],
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
            'target_model_type' => 'Target Model Type',
            'target_model_slug' => 'Target Model Slug',
        ];
    }
}
