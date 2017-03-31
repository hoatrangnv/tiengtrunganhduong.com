<?php
namespace backend\models;

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
use backend\models\Image;
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
    public $image_quantity;
    public $image_crop;
    public $image_name;
    public $image_file_basename;
    public $image_file_extension;
    public $image_name_to_basename;

    public function getValidImageExtensions()
    {
        return ['png', 'jpg', 'jpeg', 'gif', 'PNG', 'JPG', 'JPEG', 'GIF'];
    }
    
    public function getValidImageMimeTypes()
    {
        return ['image/png', 'image/jpeg', 'image/gif'];
    }

    public function rules()
    {
        return [
            [['image_files'], 'file', 'skipOnEmpty' => false,
                'mimeTypes' => $this->getValidImageMimeTypes(),
                'extensions' => $this->getValidImageExtensions(),
                'maxFiles' => 20,
                'maxSize' => 20 * 1024 * 1024,
            ],
            [['image_quantity'], 'integer', 'min' => 10, 'max' => 100],
            [['image_crop', 'image_name_to_basename'], 'boolean'],
            [['image_crop', 'image_name_to_basename'], 'default', 'value' => false],
            [['image_quantity'], 'default', 'value' => 90],
            [['image_resize_labels'], 'each', 'rule' => ['in', 'range' => array_keys(Image::getSizes())]],
            ['image_name', 'string', 'max' => 128],
            ['image_file_basename', 'string', 'max' => 128],
            ['image_file_extension', 'string', 'max' => 32],
            ['image_file_extension', 'in', 'range' => $this->getValidImageExtensions()],
        ];
    }

    public function uploadImages()
    {
        if ($this->validate()) {
            $images = [
                'saved' => [],
                'unsaved' => [],
            ];
            $i = 0;
            foreach ($this->image_files as $file) {
                $i++;
                $image = new Image();
                $image->path = $this->getImagesPath();
                $image->mime_type = $file->type;

                $image_name = $this->image_name ? $this->image_name : $file->baseName;
                if ($i == 1) {
                    $image->name = $image_name;
                } else {
                    $image->name = "$image_name $i";
                }

                if ($this->image_name_to_basename) {
                    $this->image_file_basename = Inflector::slug(MyStringHelper::stripUnicode($image_name));
                }

                if ($this->image_file_basename) {
                    if ($i == 1) {
                        $image->file_basename = $this->image_file_basename;
                    } else {
                        $image->file_basename = "$this->image_file_basename-$i";
                    }
                } else {
                    $image->file_basename = $file->baseName;
                }

                if ($this->image_file_extension) {
                    $image->file_extension = $this->image_file_extension;
                } else {
                    $image->file_extension = $file->extension;
                }

                $image->file_name = "$image->file_basename.$image->file_extension";
                $image->active = 1;

                $destination = Yii::getAlias("@images/$image->path$image->file_name");
                if ($image->validate() && $file->saveAs($destination)) {
                    $images['saved'][] = $image;

                    $resize_labels = [];
                    $image_sizes = Image::getSizes();
                    if (!is_array($this->image_resize_labels)) {
                        if ($this->image_resize_labels && is_string($this->image_resize_labels)) {
                            $this->image_resize_labels = implode(',', $this->image_resize_labels);
                        } else {
                            $this->image_resize_labels = [];
                        }
                    }
                    foreach ($this->image_resize_labels as $size_label) {
                        if (isset($image_sizes[$size_label])) {
                            $size = $image_sizes[$size_label];
                            $dimension = explode('x', $size);
                            $thumb = ImagineImage::getImagine()->open($destination);
                            if ($this->image_crop) {
                                $thumb->thumbnail(new Box($dimension[0], $dimension[1]), ManipulatorInterface::THUMBNAIL_OUTBOUND)
                                ->crop(new Point(0, 0), new Box($dimension[0], $dimension[1]));
                            } else {
                                $thumb->thumbnail(new Box($dimension[0], $dimension[1]));
                            }
                            $suffix = '-' . $thumb->getSize()->getWidth() . 'x' . $thumb->getSize()->getHeight();
                            if ($thumb->save(Yii::getAlias("@images/{$image->path}$image->file_basename{$suffix}.$image->file_extension")
                                    , ['quality' => $this->image_quantity])) {
                                $resize_labels[$size_label] = $suffix;
                            }
                        }
                    }

                    $image->resize_labels = json_encode($resize_labels);
                    $image->save();
                } else {
                    $images['unsaved'][] = $image;
                }
            }
            return $images;
        } else {
            return false;
        }
    }

    public function getImagesPath()
    {
        $path = date('Ym/');
        $full_path = Yii::getAlias("@images/$path");
        if (!file_exists($full_path)) {
            mkdir($full_path);
        }
        return $path;
    }
}