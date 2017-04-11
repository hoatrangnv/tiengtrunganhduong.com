<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 3/31/2017
 * Time: 12:30 AM
 */

namespace backend\models;

use Yii;
use yii\helpers\Url;
use yii\helpers\FileHelper;
use yii\validators\FileValidator;
use yii\web\UploadedFile;

class Image extends \common\models\Image
{
    public function getUrl($params = [])
    {
        // TODO: Implement getUrl() method.
        return Url::to(array_merge(['image/update', 'id' => $this->id], $params), true);
    }

    public $image_file;
    public $image_resize_labels;
    public $image_crop;
    public $image_quality;
    public $image_name_to_basename;
    public $image_file_basename;
    public $image_file_extension;

    public $image_source;
    public $image_source_content; // Save image source content after validate
    public $image_source_extension; // Save image source extension after validate
    public $image_source_mime_type; // Save image source mime type after validate
    public $image_source_basename; // Save image source basename after validate
    public $image_source_size; // Save image source size after validate
    public $image_source_loaded; // Check image source was loaded

    public function rules()
    {
        return array_merge(parent::rules(), [
            ['image_source', 'string'],
            ['image_source', 'url'],
            [['image_source'], 'imageSource', 'skipOnEmpty' => true,
                'params' => [
                'mimeTypes' => Image::getValidMimeTypes(),
                'extensions' => Image::getValidExtensions(),
                'maxSize' => Image::getMaxSize(),
            ]],
            [['image_file'], 'file', 'skipOnEmpty' => true,
                'mimeTypes' => Image::getValidMimeTypes(),
                'extensions' => Image::getValidExtensions(),
                'maxSize' => Image::getMaxSize(),
                'maxFiles' => 1,
            ],
            [['image_quality'], 'integer', 'min' => 10, 'max' => 100],
            [['image_crop', 'image_name_to_basename'], 'boolean'],
            [['image_crop', 'image_name_to_basename'], 'default', 'value' => false],
            [['image_quality'], 'default', 'value' => 50],
            [['image_resize_labels'], 'each', 'rule' => ['in', 'range' => array_keys(Image::getSizes())]],
            ['image_file_basename', 'string', 'max' => 128],
            ['image_file_extension', 'string', 'max' => 32],
            ['image_file_extension', 'in', 'range' => Image::getValidExtensions()],
        ]);
    }

    public function imageSource($attribute, $params)
    {
        if ($this->image_source_loaded === true) {
            return true;
        }

        if ($this->image_source_loaded === false) {
            return false;
        }

        if (!$this->image_source_content = file_get_contents($this->$attribute)) {
            $this->addError($attribute, Yii::t('app', $this->getAttributeLabel($attribute)
                . ' cannot get content.'));
            $this->image_source_loaded = false;
            return false;
        }

        // Basename
        $this->image_source_basename = md5(uniqid());

        // Mime type and extension
        $f = finfo_open();
        $this->image_source_mime_type = finfo_buffer($f, $this->image_source_content, FILEINFO_MIME_TYPE);
        finfo_close($f);

        switch ($this->image_source_mime_type) {
            case 'image/jpeg':
                $this->image_source_extension = 'jpg';
                break;
            case 'image/png':
                $this->image_source_extension = 'png';
                break;
            case 'image/gif':
                $this->image_source_extension = 'gif';
                break;
            default:
                $parse_url = parse_url($this->image_source);
                $path_info = pathinfo($parse_url['path']);
                if (isset($path_info['extension'])) {
                    $this->image_source_extension = $path_info['extension'];
                }
        }

        if (isset($params['mimeTypes']) && !in_array($this->image_source_mime_type, $params['mimeTypes'])) {
            $this->addError($attribute, Yii::t('app', $this->getAttributeLabel($attribute)
                . ' mime type must be ' . implode(', ', $params['mimeTypes']) . '.'));
            return false;
        }

        if (isset($params['extensions']) && !in_array($this->image_source_extension, $params['extensions'])) {
            $this->addError($attribute, Yii::t('app', $this->getAttributeLabel($attribute)
                . ' extension must be ' . implode(', ', $params['extensions']) . '.'));
            return false;
        }

        // Size
        if (function_exists('mb_strlen')) {
            $this->image_source_size = mb_strlen($this->image_source_content, '8bit');
        } else {
            $this->image_source_size = strlen($this->image_source_content);
        }
        if ($this->image_source_size > $params['maxSize']) {
            $this->addError($attribute, Yii::t('app', $this->getAttributeLabel($attribute)
                . ' size cannot bigger than ' . $params['maxSize'] . ' bytes.'));
            return false;
        }

        // Loaded
        $this->image_source_loaded = true;

        return true;
    }

    public function getImageSourceAsUploadedFile()
    {
        if ($this->image_source && $this->validate(['image_source'])) {
            if ($this->image_source_mime_type) {
                $temp_name = Yii::getAlias("@images/$this->image_source_basename.$this->image_source_extension");
                if (file_put_contents($temp_name, $this->image_source_content)) {
                    $file = new UploadedFile();
                    $file->name = "$this->image_source_basename.$this->image_source_extension";
                    $file->type = $this->image_source_mime_type;
                    $file->size = $this->image_source_size;
                    $file->error = UPLOAD_ERR_OK;
                    $file->tempName = $temp_name;
                    return $file;
                } else {
                    $this->addError('image_source', Yii::t('app', 'Cannot save temp image.'));
                }
            } else {
                $this->addError('image_source', Yii::t('app', 'Invalid mime type.'));
            }
        }

        return null;
    }

}