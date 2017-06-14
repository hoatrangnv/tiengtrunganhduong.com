<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\FileHelper;
use yii\helpers\Html;

/**
 * This is the model class for table "image".
 *
 * @property integer $id
 * @property integer $creator_id
 * @property integer $updater_id
 * @property string $name
 * @property string $path
 * @property string $file_basename
 * @property string $file_extension
 * @property string $resize_labels
 * @property string $encode_data
 * @property string $mime_type
 * @property integer $active
 * @property integer $status
 * @property integer $sort_order
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $quality
 * @property string $aspect_ratio
 * @property integer $width
 * @property integer $height
 *
 * @property Article[] $articles
 * @property User $creator
 * @property User $updater
 */
class Image extends \common\models\MyActiveRecord
{
    public function getUrl($params = [])
    {
        // TODO: Implement getUrl() method.
    }

    const SIZE_ORIGIN_LABEL = '-origin';
    const SIZE_RESIZE_LABEL = '-{w}x{h}';

    const SIZE_0 = 0;

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
            self::SIZE_11 => '600x600',
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
        return [
            'png', 'jpg', 'jpeg', 'gif', 'svg',
            'PNG', 'JPG', 'JPEG', 'GIF', 'SVG'
        ];
    }

    public static function getValidMimeTypes()
    {
        return ['image/png', 'image/jpeg', 'image/gif', 'image/svg+xml'];
    }

    public static function getResizeLabelBySizeKey($size_key)
    {
        return self::getResizeLabelBySize(self::getSizeBySizeKey($size_key));
    }

    public static function getResizeLabelBySize($size)
    {
        if (is_string($size)) {
            $size = static::getSizeByResizeLabel($size);
        }
        if (is_array($size) && count($size) == 2) {
            foreach ($size as &$item) {
                $item = abs((int) $item);
            }
            return preg_replace(['/{w}/', '/{h}/'], [$size[0], $size[1]], self::SIZE_RESIZE_LABEL);
        }
        return '';
    }

    public static function getSizeBySizeKey($size_key)
    {
        $image_sizes = self::getSizes();
        if (isset($image_sizes[$size_key])) {
            $size = static::getSizeByResizeLabel($image_sizes[$size_key]);
            if (count($size) == 2) {
                foreach ($size as &$item) {
                    $item = abs((int) $item);
                }
                return $size;
            }
        }
        return null;
    }

    public static function getSizeByResizeLabel($resize_label)
    {
        if (is_string($resize_label)) {
            $size = explode('x', $resize_label);
            if (count($size) == 2) {
                foreach ($size as &$item) {
                    $item = abs((int) $item);
                }
                return $size;
            }
        }
        return null;
    }

    public static function getSizeKeyBySize($size, array $image_sizes = [])
    {
        if ($size == self::SIZE_0 || isset($image_sizes[$size])) {
            return $size;
        }
        if (is_string($size)) {
            $size = self::getSizeByResizeLabel($size);
        }
        $rs_key = self::SIZE_0;
        $rs_size = [INF, INF];
        if (is_array($size) && count($size) == 2) {
            foreach ($image_sizes as $key => $resize_label) {
                $size_i = self::getSizeByResizeLabel($resize_label);
                if (is_array($size_i) && count($size_i) == 2) {
                    if ( $size_i[0] >= $size[0] && $size_i[1] >= $size[1]
                      && $size_i[0] <= $rs_size[0] && $size_i[1] <= $rs_size[1]
                    ) {
                        $rs_key = $key;
                        $rs_size = $size_i;
                    }
                }
            }
        }
        return $rs_key;
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
            return Yii::getAlias("@imagesUrl/{$this->path}$this->file_basename.$this->file_extension");
        }
        return Yii::getAlias("@imagesUrl/{$this->path}$this->file_basename{$size_label}.$this->file_extension");
    }

    public function getLocation($size_label = null)
    {
        if ($size_label == null) {
            return Yii::getAlias("@images/{$this->path}$this->file_basename.$this->file_extension");
        }
        return Yii::getAlias("@images/{$this->path}$this->file_basename{$size_label}.$this->file_extension");
    }

    public function getOldLocation($size_label = null)
    {
        if ($size_label == null) {
            return Yii::getAlias("@images/{$this->getOldAttribute('path')}{$this->getOldAttribute('file_basename')}.{$this->getOldAttribute('file_extension')}");
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
     * @var
     */
    private $_img_srcs;

    /**
     * @var
     */
    private $_img_sizes;

    /**
     * @var
     */
    private $_timestamp;

    public function init()
    {
        $this->_timestamp = time();

        parent::init();
    }

    /**
     * @param int $size
     * @param array $options
     * @return mixed
     */
    public function getImgName($size = Image::SIZE_0, $options = [])
    {
        return pathinfo($this->getImgSrc($size, $options), PATHINFO_BASENAME);
    }

    /**
     * @param $size
     * @param array $options
     * @return mixed|string
     */
    public function getImgSrc($size = Image::SIZE_0, $options = [])
    {
        // Initialize
        if (is_null($this->_img_srcs)) {
            $this->_img_srcs = [];
            $this->_img_sizes = [];

            $this->_img_srcs[Image::SIZE_0] = $this->getSource();
            $img_sizes = json_decode($this->resize_labels, true);

            if (is_array($img_sizes)) {
                ksort($img_sizes);
                foreach ($img_sizes as $key => $label) {
                    $this->_img_srcs[$key] = $this->getSource($label);
                }
                $this->_img_sizes = $img_sizes;
            }
        }

//        if (isset($options['timestamp']) && $options['timestamp'] === true) {
//            $timestamp = '?v=' . $this->_timestamp;
//        } else {
//            $timestamp = '';
//        }

        if (empty($options)) {
            $queryStr = '';
        } else {
            $queryStr = '?';
            foreach ($options as $key => $value) {
                if ((is_string($key) || is_numeric($key))
                    && (is_string($value) || is_numeric($value))
                ) {
                    $queryStr .= "$key=$value";
                }
            }
        }

        // Get image src by size key or size
        $size_key = Image::getSizeKeyBySize($size , $this->_img_sizes);
        foreach ($this->_img_srcs as $key => $img_src) {
            if ($key >= $size_key) {
                return $this->_img_srcs[$key] . $queryStr;
            }
        }
        return (isset($this->_img_srcs[Image::SIZE_0]) ? $this->_img_srcs[Image::SIZE_0] : '') . $queryStr;
    }

    /**
     * @param null $size
     * @param array $options
     * @param array $srcOptions
     * @return string
     */
    public function getImgTag($size = null, array $options = [], array $srcOptions = [])
    {
        $src = $this->getImgSrc($size, $srcOptions);
        return Html::img($src, $options);
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
            [[
                /*'creator_id', 'updater_id',*/
                'active', 'status', 'sort_order',
                /*'create_time', 'update_time'*/
                'width', 'height'
            ], 'integer'],
            [['name', /*'path',*/ 'file_basename'], 'string', 'max' => 255],
            [['file_extension', /*'mime_type', 'aspect_ratio'*/], 'string', 'max' => 32],
            [['resize_labels', 'encode_data'], 'string', 'max' => 2047],
            [['file_basename'], 'unique'],
            [['file_extension'], 'in', 'range' => Image::getValidExtensions()],
//            [['creator_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creator_id' => 'id']],
//            [['updater_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updater_id' => 'id']],
            [['quality'], 'integer', 'min' => 1, 'max' => 100],
            [['quality'], 'default', 'value' => 50],
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
            'file_basename' => 'File Basename',
            'file_extension' => 'File Extension',
            'resize_labels' => 'Resize Labels',
            'encode_data' => 'Encode Data',
            'mime_type' => 'Mime Type',
            'active' => 'Active',
            'status' => 'Status',
            'sort_order' => 'Sort Order',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'quality' => 'Quality',
            'aspect_ratio' => 'Aspect Ratio',
            'width' => 'Width',
            'height' => 'Height',
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

    /**
     * Query Template
     */

    /**
     * @return array
     */
    public function templateMethods()
    {
        return [
            'attribute' => function ($name) {
                return $this->getAttribute($name);
            },
            'imgTag' => function ($size = Image::SIZE_0, $options = [], $srcOptions = []) {
                if (Yii::$app->controller
                    && in_array(Yii::$app->controllerNamespace, ['backend\\controllers'])
                ) {
                    $srcOptions = array_merge($srcOptions, ['id' => $this->id]);
                }
                return $this->img($size, $options, $srcOptions);
            },
            'source' => function ($size = Image::SIZE_0, $options = []) {
                return $this->getImgSrc($size, $options);
            },
            'filename' => function ($size = Image::SIZE_0, $options = []) {
                return $this->getImgName($size, $options);
            },
        ];
    }

}
