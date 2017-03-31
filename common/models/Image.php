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
 * @property string $file_basename
 * @property string $file_extension
 * @property string $resize_labels
 * @property string $string_data
 * @property string $mime_type
 * @property integer $active
 * @property integer $status
 * @property integer $sort_order
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
    const LABEL_ORIGIN = '-origin';
    const LABEL_SIZE = '-{w}x{h}';

    const SIZE_S1 = 's1';
    const SIZE_S2 = 's2';
    const SIZE_S3 = 's3';
    const SIZE_S4 = 's4';
    const SIZE_S5 = 's5';
    const SIZE_S6 = 's6';
    const SIZE_S7 = 's7';
    const SIZE_S8 = 's8';
    const SIZE_S9 = 's9';
    const SIZE_S10 = 's10';
    const SIZE_S11 = 's11';
    const SIZE_S12 = 's12';
    const SIZE_S13 = 's13';
    const SIZE_S14 = 's14';
    const SIZE_S15 = 's15';

    public static function getSizes()
    {
        return [
            self::SIZE_S1 => '50x50',
            self::SIZE_S2 => '100x100',
            self::SIZE_S3 => '150x150',
            self::SIZE_S4 => '200x200',
            self::SIZE_S5 => '250x250',
            self::SIZE_S6 => '300x300',
            self::SIZE_S7 => '350x350',
            self::SIZE_S8 => '400x400',
            self::SIZE_S9 => '450x450',
            self::SIZE_S10 => '500x500',
            self::SIZE_S11 => '200x600',
            self::SIZE_S12 => '800x800',
            self::SIZE_S13 => '1000x1000',
            self::SIZE_S14 => '1200x1200',
            self::SIZE_S15 => '1400x1400',
        ];
    }

    public static function getValidExtensions()
    {
        return ['png', 'jpg', 'jpeg', 'gif', 'PNG', 'JPG', 'JPEG', 'GIF'];
    }

    public static function getValidMimeTypes()
    {
        return ['image/png', 'image/jpeg', 'image/gif'];
    }

    public static function getImagesPath()
    {
        $path = date('Ym/');
        $full_path = Yii::getAlias("@images/$path");
        if (!file_exists($full_path)) {
            mkdir($full_path);
        }
        return $path;
    }

    public function getSource($size_label = null)
    {
        if ($size_label == null) {
            return Yii::getAlias("@imagesUrl/{$this->path}$this->file_name");
        }
        return Yii::getAlias("@imagesUrl/{$this->path}$this->file_basename{$size_label}.$this->file_extension");
    }

    public function getLocation($size_label = null)
    {
        if ($size_label == null) {
            return Yii::getAlias("@images/{$this->path}$this->file_name");
        }
        return Yii::getAlias("@images/{$this->path}$this->file_basename{$size_label}.$this->file_extension");
    }

    public function getOldLocation($size_label = null)
    {
        if ($size_label == null) {
            return Yii::getAlias("@images/{$this->getOldAttribute('path')}{$this->getOldAttribute('file_name')}");
        }
        return Yii::getAlias("@images/{$this->getOldAttribute('path')}{$this->getOldAttribute('file_basename')}$size_label.{$this->getOldAttribute('file_extension')}");
    }



    public function getResizeLabels()
    {
        $result = json_decode($this->resize_labels, true);
        if (is_array($result)) {
            return $result;
        }
        return [];
    }

    public function getOldResizeLabels()
    {
        $result = json_decode($this->getOldAttribute('resize_labels'), true);
        if (is_array($result)) {
            return $result;
        }
        return [];
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
        return 'image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[/*'creator_id', 'updater_id',*/ 'active', 'status', 'sort_order', 'views', 'likes', 'comments', 'shares', /*'create_time', 'update_time'*/], 'integer'],
            [['name', /*'path',*/ 'file_name'], 'required'],
            [['name', /*'path',*/ 'file_name', 'file_basename'], 'string', 'max' => 128],
            [['file_extension', /*'mime_type'*/], 'string', 'max' => 32],
            [['resize_labels', 'string_data'], 'string', 'max' => 2048],
            [['file_name', 'file_basename'], 'unique'],
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
            'file_basename' => 'File Basename',
            'file_extension' => 'File Extension',
            'resize_labels' => 'Resize Labels',
            'string_data' => 'String Data',
            'mime_type' => 'Mime Type',
            'active' => 'Active',
            'status' => 'Status',
            'sort_order' => 'Sort Order',
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
