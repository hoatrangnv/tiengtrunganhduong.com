<?php

namespace common\modules\audio\baseModels;

use common\db\MyActiveRecord;
use Yii;
use common\models\User;

/**
 * This is the model class for table "audio".
 *
 * @property integer $id
 * @property string $name
 * @property string $path
 * @property string $file_basename
 * @property string $file_extension
 * @property string $mime_type
 * @property integer $duration
 * @property integer $quality
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $creator_id
 * @property integer $updater_id
 *
 * @property User $creator
 * @property User $updater
 */
class Audio extends MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'audio';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'file_basename', 'file_extension', 'mime_type', 'create_time', 'creator_id'], 'required'],
            [['duration', 'quality', 'create_time', 'update_time', 'creator_id', 'updater_id'], 'integer'],
            [['name', 'path', 'file_basename', 'file_extension', 'mime_type'], 'string', 'max' => 255],
            [['file_basename'], 'unique'],
            [['creator_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creator_id' => 'id'], 'except' => 'test'],
            [['updater_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updater_id' => 'id'], 'except' => 'test'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'path' => 'Path',
            'file_basename' => 'File Basename',
            'file_extension' => 'File Extension',
            'mime_type' => 'Mime Type',
            'duration' => 'Duration',
            'quality' => 'Quality',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'creator_id' => 'Creator ID',
            'updater_id' => 'Updater ID',
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
