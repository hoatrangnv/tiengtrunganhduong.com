<?php
namespace backend\models;

use common\models\MyActiveRecord;
use common\helpers\MyStringHelper;
use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\helpers\Inflector;
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
    public $imageFiles;
    public $resizeLabels;
    public $quantity;
    public $crop;
    public $images_name;
    public $images_file_basename;
    public $images_file_extension;
    public $images_name_to_basename;

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
            [['imageFiles'], 'file', 'skipOnEmpty' => false,
                'mimeTypes' => $this->getValidImageMimeTypes(),
                'extensions' => $this->getValidImageExtensions(),
                'maxFiles' => 20,
                'maxSize' => 20 * 1024 * 1024,
            ],
            [['quantity'], 'integer', 'min' => 10, 'max' => 100],
            [['crop', 'images_name_to_basename'], 'boolean'],
            [['crop', 'images_name_to_basename'], 'default', 'value' => false],
            [['quantity'], 'default', 'value' => 90],
            [['resizeLabels'], 'each', 'rule' => ['in', 'range' => array_keys(Image::getSizes())]],
            ['images_name', 'string', 'max' => 128],
            ['images_file_basename', 'string', 'max' => 128],
            ['images_file_extension', 'string', 'max' => 32],
            ['images_file_extension', 'in', 'range' => $this->getValidImageExtensions()],
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
            foreach ($this->imageFiles as $file) {
                $i++;
                $image = new Image();
                $image->path = $this->getImagesPath();
                $image->mime_type = $file->type;

                $image_name = $this->images_name ? $this->images_name : $file->baseName;
                if ($i == 1) {
                    $image->name = $image_name;
                } else {
                    $image->name = "$image_name $i";
                }

                if ($this->images_name_to_basename) {
                    $this->images_file_basename = Inflector::slug(MyStringHelper::vietnameseFilter($image_name));
                }

                if ($this->images_file_basename) {
                    if ($i == 1) {
                        $image->file_basename = $this->images_file_basename;
                    } else {
                        $image->file_basename = "$this->images_file_basename-$i";
                    }
                } else {
                    $image->file_basename = $file->baseName;
                }

                if ($this->images_file_extension) {
                    $image->file_extension = $this->images_file_extension;
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
                    if (!is_array($this->resizeLabels)) {
                        if ($this->resizeLabels && is_string($this->resizeLabels)) {
                            $this->resizeLabels = implode(',', $this->resizeLabels);
                        } else {
                            $this->resizeLabels = [];
                        }
                    }
                    foreach ($this->resizeLabels as $size_label) {
                        if (isset($image_sizes[$size_label])) {
                            $size = $image_sizes[$size_label];
                            $dimension = explode('x', $size);
                            ImagineImage::getImagine()->open($destination)
                                ->thumbnail(new Box($dimension[0], $dimension[1]))
                                ->save(Yii::getAlias("@images/{$image->path}$image->file_basename{$size_label}.$image->file_extension")
                                    , ['quality' => $this->quantity]);

                            $resize_labels[] = $size_label;
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