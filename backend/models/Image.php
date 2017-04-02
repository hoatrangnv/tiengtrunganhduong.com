<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 3/31/2017
 * Time: 12:30 AM
 */

namespace backend\models;

use Yii;
use yii\helpers\FileHelper;
use yii\validators\FileValidator;

class Image extends \common\models\Image
{
    public $image_file;
    public $image_resize_labels;
    public $image_crop;
    public $image_quality;
    public $image_name_to_basename;
    public $image_file_basename;
    public $image_file_extension;

    public $image_source;
    public $image_content; // Save image content after validate

    public function rules()
    {
        return array_merge(parent::rules(), [
            ['image_source', 'string'],
            ['image_source', 'url'],
            [['image_source'], 'imageSource',
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
        if (isset($params['extensions'])) {
            $parse_url = parse_url($this->image_source);
            $path_info = pathinfo($parse_url['path']);
            if (!isset($path_info['extension']) || !in_array($path_info['extension'], $params['extensions'])) {
                $this->addError($attribute, Yii::t('app', $this->getAttributeLabel($attribute)
                    . ' extension must be ' . implode(', ', $params['extensions'])));
                return false;
            }
        }
        if (isset($params['mimeTypes']) || isset($params['maxSize'])) {
            $file_content = file_get_contents($this->$attribute);

            if (isset($params['mimeTypes'])) {
                $f = finfo_open();
                $mime_type = finfo_buffer($f, $file_content, FILEINFO_MIME_TYPE);
                if (!in_array($mime_type, $params['mimeTypes'])) {
                    $this->addError($attribute, Yii::t('app', $this->getAttributeLabel($attribute)
                        . ' mime type must be ' . implode(', ', $params['mimeTypes'])));
                    return false;
                }
                finfo_close($f);
            }

            if (isset($params['maxSize'])) {
                if (function_exists('mb_strlen')) {
                    $size = mb_strlen($file_content, '8bit');
                } else {
                    $size = strlen($file_content);
                }
                if ($size > $params['maxSize']) {
                    $this->addError($attribute, Yii::t('app', $this->getAttributeLabel($attribute)
                        . ' size cannot bigger than ' . $params['maxSize'] . ' bytes'));
                    return false;
                }
            }

            // @TODO: Save to use after without get content again
            $this->image_content = $file_content;
        }
        return true;
    }

}