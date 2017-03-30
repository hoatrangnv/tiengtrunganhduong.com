<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "image".
 *
 * @property integer $id
 * @property integer $creator_id
 * @property integer $updater_id
 * @property string $name
 * @property string $path
 * @property string $file_name
 * @property string $resize_list
 * @property string $string_data
 * @property string $mime_type
 * @property string $sort_order
 * @property integer $active
 * @property integer $views
 * @property integer $likes
 * @property integer $comments
 * @property integer $shares
 * @property integer $create_time
 * @property integer $update_time
 *
 * @property Article[] $articles
 * @property User $creator
 * @property User $updater
 */
class Image extends \common\models\MyActiveRecord
{
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

    public function getSource()
    {
        return Yii::getAlias("@imagesUrl/$this->path$this->file_name");
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[/*'creator_id', 'updater_id',*/ 'active', 'views', 'likes', 'comments', 'shares', /*'create_time', 'update_time'*/], 'integer'],
            [['name', 'path', 'file_name'], 'required'],
            [['name', 'path', 'file_name'], 'string', 'max' => 128],
            [['resize_list', 'string_data'], 'string', 'max' => 2048],
            [['mime_type', 'sort_order'], 'string', 'max' => 32],
            [['file_name'], 'unique'],
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
            'path' => 'Path',
            'file_name' => 'File Name',
            'resize_list' => 'Resize List',
            'string_data' => 'String Data',
            'mime_type' => 'Mime Type',
            'sort_order' => 'Sort Order',
            'active' => 'Active',
            'views' => 'Views',
            'likes' => 'Likes',
            'comments' => 'Comments',
            'shares' => 'Shares',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(Article::className(), ['image_id' => 'id']);
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
