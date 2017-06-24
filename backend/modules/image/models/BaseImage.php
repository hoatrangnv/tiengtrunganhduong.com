<?php
/**
 * Created by PhpStorm.
 * User: Quyet
 * Date: 6/24/2017
 * Time: 12:04 PM
 */

namespace app\modules\models;

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
 */

class BaseImage extends ActiveRecord
{

    const LABEL_DEFAULT = '';

    const LABEL_ORIGIN = '-origin';

    const LABEL_RESIZE = '-{w}x{h}';

    public static function getMaxImageSize()
    {
        return 2 * 1024 * 1024;
    }

    public static function getValidImageExtensions()
    {
        return [
            'png', 'jpg', 'jpeg', 'gif', 'svg',
            'PNG', 'JPG', 'JPEG', 'GIF', 'SVG'
        ];
    }

    public static function getValidImageMimeTypes()
    {
        return ['image/png', 'image/jpeg', 'image/gif', 'image/svg+xml'];
    }

    public static function getImageResizeLabel($input)
    {
        $dimensions = static::imageDimensionsIfy($input);
        if (!empty($dimensions)) {
            foreach ($dimensions as &$item) {
                $item = abs((int) $item);
            }
            return preg_replace(['/{w}/', '/{h}/'], [$dimensions[0], $dimensions[1]], self::LABEL_RESIZE);
        }
        return '';
    }

    /**
     * @param $input
     * @return array
     */
    public static function imageDimensionsIfy($input)
    {
        $dims = [];
        $temp = null;

        if (is_array($input)) {
            $temp = $input;
        } else if (is_string($input)) {
            $temp = explode('x', $input);
        }

        if (is_array($temp) && count($temp) > 1) {
            $i = 0;
            foreach ($temp as $item) {
                $dims[] = abs((int) $item);
                $i++;
                if ($i == 2) {
                    break;
                }
            }
        }

        return $dims;
    }

    public static function getImageLabelByMinSize($min_size, array $image_sizes = [])
    {
        $min_dims = self::imageDimensionsIfy($min_size);
        $final_label = self::LABEL_DEFAULT;
        if (!empty($min_dims)) {
            $final_dims = [INF, INF];
            foreach ($image_sizes as $image_size) {
                $image_dims = self::imageDimensionsIfy($image_size);
                if (!empty($image_dims)) {
                    if (
                        $image_dims[0] >= $min_dims[0] &&
                        $image_dims[0] <= $final_dims[0] &&
                        $image_dims[1] >= $min_dims[1] &&
                        $image_dims[1] <= $final_dims[1]
                    ) {
                        $final_dims = $image_dims;
                        $final_label = self::getImageResizeLabel($image_dims);
                    }
                }
            }
        }
        return $final_label;
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

    public function getSource($label = self::LABEL_DEFAULT)
    {
        return Yii::getAlias("@imagesUrl/{$this->path}$this->file_basename{$label}.$this->file_extension");
    }

    public function getLocation($label = self::LABEL_DEFAULT)
    {
        return Yii::getAlias("@images/{$this->path}$this->file_basename{$label}.$this->file_extension");
    }

    public function getOldLocation($label = self::LABEL_DEFAULT)
    {
        return Yii::getAlias("@images/{$this->getOldAttribute('path')}{$this->getOldAttribute('file_basename')}$label.{$this->getOldAttribute('file_extension')}");
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
    private $_imgSources;

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
     * @param string $size
     * @param array $options
     * @return mixed
     */
    public function getImgName($size = null, $options = [])
    {
        return pathinfo($this->getImgSrc($size, $options), PATHINFO_BASENAME);
    }

    /**
     * @param $size
     * @param array $options
     * @return mixed|string
     */
    public function getImgSrc($size = null, $options = [])
    {
        // Initialize
        if (is_null($this->_imgSources)) {
            $this->_imgSources = [];

            $this->_imgSources[Image::LABEL_DEFAULT] = $this->getSource();

            if (is_array($resize_labels = json_decode($this->resize_labels, true))) {
                foreach ($resize_labels as $label) {
                    $this->_imgSources[$label] = $this->getSource($label);
                }
            }
        }

        // Query string
        $queryStr = '';
        if (!empty($options)) {
            $queryStr = '?';
            $i = 0;
            foreach ($options as $key => $value) {
                $i++;
                if ($i > 1) {
                    $queryStr .= '&';
                }
                if ($key == 'appendTimestamp' && !!$value) {
                    $queryStr .= "$key=$this->_timestamp";
                } else if (
                    (is_string($key) || is_numeric($key)) &&
                    (is_string($value) || is_numeric($value))
                ) {
                    $queryStr .= "$key=$value";
                }
            }
        }

        // Return an img source
        $label = Image::getImageLabelByMinSize($size, array_keys($this->_imgSources));
        if (isset($this->_imgSources[$label])) {
            return $this->_imgSources[$label] . $queryStr;
        }

        // Fallback to empty string
        return '';
    }

    /**
     * @param null $size
     * @param array $options
     * @param array $srcOptions
     * @return string
     */
    public function img($size = null, array $options = [], array $srcOptions = [])
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
            [['name', 'path', 'file_basename'], 'string', 'max' => 255],
            [['file_extension', 'mime_type', 'aspect_ratio'], 'string', 'max' => 32],
            [['resize_labels', 'encode_data'], 'string', 'max' => 2047],
            [['file_basename'], 'unique'],
            [['file_extension'], 'in', 'range' => Image::getValidImageExtensions()],
            [['mime_type'], 'in', 'range' => Image::getValidImageMimeTypes()],
//            [['creator_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creator_id' => 'id']],
//            [['updater_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updater_id' => 'id']],
            [['quality'], 'integer', 'min' => 1, 'max' => 100],
            [['quality'], 'default', 'value' => 60],
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

}