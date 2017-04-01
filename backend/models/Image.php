<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 3/31/2017
 * Time: 12:30 AM
 */

namespace backend\models;

use Yii;

class Image extends \common\models\Image
{
    public $image_source;
    public $image_file;
    public $image_resize_labels;
    public $image_crop;
    public $image_quality;
    public $image_name_to_basename;
    public $image_file_basename;
    public $image_file_extension;

    public function rules()
    {
        return array_merge(parent::rules(), [
            ['image_source', 'string'],
            [['image_file'], 'file', 'skipOnEmpty' => true,
                'mimeTypes' => Image::getValidMimeTypes(),
                'extensions' => Image::getValidExtensions(),
                'maxFiles' => 20,
                'maxSize' => 20 * 1024 * 1024,
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

}