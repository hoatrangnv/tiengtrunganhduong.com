<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\FileHelper;

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

    const SIZE_1 = 1;
    const SIZE_2 = 2;
    const SIZE_3 = 3;
    const SIZE_4 = 3;
    const SIZE_5 = 4;
    const SIZE_6 = 5;
    const SIZE_7 = 6;
    const SIZE_8 = 7;
    const SIZE_9 = 8;
    const SIZE_10 = 9;
    const SIZE_11 = 10;
    const SIZE_12 = 11;
    const SIZE_13 = 12;
    const SIZE_14 = 13;
    const SIZE_15 = 14;

    public static function getSizes()
    {
        return [
            self::SIZE_1 => '50x50',
            self::SIZE_2 => '100x100',
            self::SIZE_3 => '150x150',
            self::SIZE_4 => '200x200',
            self::SIZE_5 => '250x250',
            self::SIZE_6 => '300x300',
            self::SIZE_7 => '350x350',
            self::SIZE_8 => '400x400',
            self::SIZE_9 => '450x450',
            self::SIZE_10 => '500x500',
            self::SIZE_11 => '200x600',
            self::SIZE_12 => '800x800',
            self::SIZE_13 => '1000x1000',
            self::SIZE_14 => '1200x1200',
            self::SIZE_15 => '1400x1400',
        ];
    }

    public static function getMaxSize()
    {
        return 2 * 1024 * 1024;
    }

    public static function getValidExtensions()
    {
        return ['png', 'jpg', 'jpeg', 'gif', 'PNG', 'JPG', 'JPEG', 'GIF'];
    }

    public static function getValidMimeTypes()
    {
        return ['image/png', 'image/jpeg', 'image/gif'];
    }

    public function getLabelFromSize($sizes)
    {
        if (is_string($sizes)) {
            $sizes = explode('x', $sizes);
        }
        if (is_array($sizes) && count($sizes) == 2) {
            foreach ($sizes as &$size) {
                $size = abs((int) $size);
            }
            return preg_replace(['/{w}/', '/{h}/'], [$sizes[0], $sizes[1]], self::LABEL_SIZE);
        }
        return '';
    }

    public function getSizeFromLabel($label)
    {
        $image_sizes = self::getSizes();
        if (isset($image_sizes[$label])) {
            $sizes = explode('x', $image_sizes[$label]);
            foreach ($sizes as &$size) {
                $size = abs((int) $size);
            }
            return $sizes;
        }
        return null;
    }

    public function getDirectory()
    {
        return Yii::getAlias("@images/$this->path");
    }

    public function getOldDirectory()
    {
        return Yii::getAlias("@images/{$this->getOldAttribute('path')}");
    }

    public function generatePath()
    {
        $time = $this->create_time ? $this->create_time : time();
        $this->path = date('Ym/', $time);
        if ($this->file_basename) {
            $this->path .= "$this->file_basename/";
        } else {
            $this->path .= date('d/', $time);
        }
        $dir = Yii::getAlias("@images/$this->path");
        if (!file_exists($dir)) {
            FileHelper::createDirectory($dir);
        }
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
