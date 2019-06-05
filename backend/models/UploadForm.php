<?php
namespace backend\models;

use backend\models\Image;
use common\models\Audio;
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
    public $audio_files;
    public $audio_name;
    public $audio_file_basename;
    public $audio_file_extension;
    public $audio_name_to_basename;

    /**
     * @var UploadedFile
     */
    public $file;

    public function rules()
    {
        return [
            [['image_files'], 'file', 'skipOnEmpty' => true,
                'mimeTypes' => Image::getValidImageMimeTypes(),
                'extensions' => Image::getValidImageExtensions(),
                'maxSize' => Image::getMaxImageSize(),
                'maxFiles' => 20,
            ],
            [['image_quality'], 'integer', 'min' => 1, 'max' => 100],
            [['image_quality'], 'default', 'value' => 50],
            [['image_crop', 'image_name_to_basename'], 'boolean'],
            [['image_crop', 'image_name_to_basename'], 'default', 'value' => false],
            ['image_name', 'string', 'max' => 128],
            ['image_file_basename', 'string', 'max' => 128],
            ['image_file_extension', 'string', 'max' => 32],
            ['image_file_extension', 'in', 'range' => Image::getValidImageExtensions()],

            [['audio_files'], 'file', 'skipOnEmpty' => true,
                'mimeTypes' => Audio::getValidAudioMimeTypes(),
                'extensions' => Audio::getValidAudioExtensions(),
                'maxSize' => Audio::getMaxAudioSize(),
                'maxFiles' => 50,
            ],
            ['audio_name', 'string', 'max' => 128],
            ['audio_file_basename', 'string', 'max' => 128],
            ['audio_file_extension', 'string', 'max' => 32],
            ['audio_file_extension', 'in', 'range' => Audio::getValidAudioExtensions()],

            ['file', 'file'],
        ];
    }

    public function uploadImages()
    {
        $module = Yii::$app->getModule('image2');
        if ($this->validate()) {
            $images = [
                'saved' => [],
                'unsaved' => [],
            ];
            foreach ($this->image_files as $file) {
                $image = new Image();
                $image->active = 1;
                $image->image_crop = $this->image_crop;
                $image->quality = $this->image_quality;
                $image->image_name_to_basename = true;
                $image->input_resize_keys = $module->params['input_resize_keys'];
                if ($image->saveFileAndModel($file)) {
                    $images['saved'][] = $image;
                } else {
                    $images['unsaved'][] = $image;
                }
            }
            return $images;
        } else {
            return false;
        }
    }

    public function uploadAudios()
    {
        if ($this->validate()) {
            $audios = [
                'saved' => [],
                'unsaved' => [],
            ];
            foreach ($this->audio_files as $file) {
                $audio = new Audio();
                $audio->audio_name_to_basename = true;
                if ($audio->saveFileAndModel($file)) {
                    $audios['saved'][] = $audio;
                } else {
                    $audios['unsaved'][] = $audio;
                }
            }
            return $audios;
        } else {
            return false;
        }
    }

    public function uploadFile()
    {
        if ($this->validate()) {
            $this->file->saveAs(Yii::getAlias('@uploads/' . date('Ymd_His__') . $this->file->baseName . '.' . $this->file->extension));
            return true;
        } else {
            return false;
        }
    }
}