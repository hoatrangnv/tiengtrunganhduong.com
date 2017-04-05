<?php
namespace backend\models;

use backend\models\Image;
use common\models\MyActiveRecord;
use common\helpers\MyStringHelper;
use Imagine\Image\ManipulatorInterface;
use Imagine\Image\Point;
use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\helpers\Inflector;
use yii\helpers\VarDumper;
use yii\web\UploadedFile;
use yii\imagine\Image as ImagineImage;
use Imagine\Gd;
use Imagine\Image\Box;
use Imagine\Image\BoxInterface;

class UploadForm extends Model
{
    /**
     * @var UploadedFile[]
     */
    public $image_files;
    public $image_resize_labels;
    public $image_quality;
    public $image_crop;
    public $image_name;
    public $image_file_basename;
    public $image_file_extension;
    public $image_name_to_basename;

    public function rules()
    {
        return [
            [['image_files'], 'file', 'skipOnEmpty' => false,
                'mimeTypes' => Image::getValidMimeTypes(),
                'extensions' => Image::getValidExtensions(),
                'maxSize' => Image::getMaxSize(),
                'maxFiles' => 20,
            ],
            [['image_quality'], 'integer', 'min' => 10, 'max' => 100],
            [['image_crop', 'image_name_to_basename'], 'boolean'],
            [['image_crop', 'image_name_to_basename'], 'default', 'value' => false],
            [['image_quality'], 'default', 'value' => 50],
            [['image_resize_labels'], 'each', 'rule' => ['in', 'range' => array_keys(Image::getSizes())]],
            ['image_name', 'string', 'max' => 128],
            ['image_file_basename', 'string', 'max' => 128],
            ['image_file_extension', 'string', 'max' => 32],
            ['image_file_extension', 'in', 'range' => Image::getValidExtensions()],
        ];
    }

    public function uploadImages()
    {
        if ($this->validate()) {
            $images = [
                'saved' => [],
                'unsaved' => [],
            ];
            $i = 1;
            foreach ($this->image_files as $file) {
                $model = new Image();

                $model->mime_type = $file->type;

                $image_name = $this->image_name ? $this->image_name : $file->baseName;

                if ($i == 1 || !$this->image_name_to_basename) {
                    $model->name = $image_name;
                } else {
                    $model->name = strpos($image_name, ' ') === false ? "$image_name-$i" : "$image_name $i";
                }

                if ($this->image_name_to_basename) {
                    $this->image_file_basename = Inflector::slug(MyStringHelper::stripUnicode($model->name));
                }

                if ($this->image_file_basename) {
                    if ($i == 1 || !$this->image_name_to_basename) {
                        $model->file_basename = $this->image_file_basename;
                    } else {
                        $model->file_basename = "$this->image_file_basename-$i";
                    }
                } else {
                    $model->file_basename = $file->baseName;
                }

                if ($this->image_file_extension) {
                    $model->file_extension = $this->image_file_extension;
                } else {
                    $model->file_extension = $file->extension;
                }

                $model->active = 1;

                // @TODO: Save origin image
                $model->generatePath();
                $origin_destination = $model->getLocation(Image::SIZE_ORIGIN_LABEL);
                $file->saveAs($origin_destination);

                // @TODO: Save cropped and compressed images
                $destination = $model->getLocation();
                $thumb0 = ImagineImage::getImagine()->open($origin_destination);

                if ($model->validate() && $thumb0->save($destination, ['quality' => $this->image_quality])) {
                    $i++;
                    $images['saved'][] = $model;

                    $resize_labels = [];
                    $this->image_resize_labels = Image::castToArray($this->image_resize_labels);
                    foreach ($this->image_resize_labels as $size_label) {
                        if ($dimension = Image::getSizeBySizeKey($size_label)) {
                            if ($this->image_crop) {
                                $thumb = ImagineImage::getImagine()->open($origin_destination)
                                ->thumbnail(new Box($dimension[0], $dimension[1]), ManipulatorInterface::THUMBNAIL_OUTBOUND)
                                ->crop(new Point(0, 0), new Box($dimension[0], $dimension[1]));
                            } else {
                                $thumb = ImagineImage::getImagine()->open($origin_destination)
                                    ->thumbnail(new Box($dimension[0], $dimension[1]));
                            }
                            $suffix = Image::getResizeLabelBySize([$thumb->getSize()->getWidth(), $thumb->getSize()->getHeight()]);
                            if ($thumb->save($model->getLocation($suffix), ['quality' => $model->image_quality])) {
                                $resize_labels[$size_label] = $suffix;
                            }
                        }
                    }

                    $model->resize_labels = json_encode($resize_labels);

                    $model->save();
                } else {
                    $images['unsaved'][] = $model;
                }
            }
            return $images;
        } else {
            return false;
        }
    }

}