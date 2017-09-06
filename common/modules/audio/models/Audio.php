<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 8/21/2017
 * Time: 10:35 PM
 */

namespace common\modules\audio\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;
use common\modules\helpers\Inflector;
use common\modules\helpers\FileHelper;

class Audio extends \common\modules\audio\baseModels\Audio
{
    /**
     * @var UploadedFile
     */
    public $audio_file;
    public $audio_name_to_basename;

    public static function getMaxAudioSize() {
        return 12 * 1024 * 1024;
    }

    public static function getValidAudioMimeTypes() {
        return [
            'audio/mpeg',
            'audio/x-mpeg',
            'audio/mpeg3',
            'audio/x-mpeg-3',
            'audio/mp3',
            'audio/wav',
            'audio/x-wav',
        ];
    }

    public static function getValidAudioExtensions() {
        return array_reduce([
            'm2a',
            'mp2',
            'mp3',
            'mpa',
            'mpg',
            'mpga',
            'wav',
        ], function ($arr, $item) {
            $arr[] = $item;
            $arr[] = strtoupper($item);
            return $arr;
        }, []);
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
    public function rules()
    {
        return [
            [['name', 'file_basename', 'file_extension', 'mime_type'], 'required', 'except' => 'form'],
            [['duration', 'quality'], 'integer'],
            [['name', 'path', 'file_basename', 'file_extension', 'mime_type'], 'string', 'max' => 255],
            [['file_basename'], 'unique'],
            [['audio_file'], 'file', 'skipOnEmpty' => true,
                'mimeTypes' => Audio::getValidAudioMimeTypes(),
                'extensions' => Audio::getValidAudioExtensions(),
                'maxSize' => Audio::getMaxAudioSize(),
                'maxFiles' => 1,
            ],
        ];
    }

    public function saveFileAndModel(UploadedFile $file = null)
    {

            if ($file === null) {
                $file = UploadedFile::getInstance($this, 'audio_file');
            }

            if ($file) {
                $this->mime_type = $file->type;

                if (!$this->name) {
                    $this->name = $file->basename;
                }

                if ($this->audio_name_to_basename) {
                    $this->file_basename = Inflector::slug($this->name);
                } else if (!$this->file_basename) {
                    $this->file_basename = $file->baseName;
                }

                if (!$this->file_extension) {
                    $this->file_extension = $file->extension;
                }

                // @TODO: Save original audio
                $this->generatePath();
                if ($file->saveAs($this->getLocation())) {
                    if ($this->save()) {
                        return true;
                    }
                } else {
                    $this->addError('audio_file', Yii::t('app', 'Cannot save audio or file is not audio.'));
                }
            } else {
                $this->addError('audio_file', Yii::t('app', 'No audio was uploaded.'));
            }
        return false;
    }

    public function updateFileAndModel(UploadedFile $file = null)
    {
        if ($this->validate()) {

            if ($file === null) {
                $file = UploadedFile::getInstance($this, 'audio_file');
            }

            if ($file) {
                $this->mime_type = $file->type;

                if (!$this->file_basename || $this->file_basename == $this->getOldAttribute('file_basename')) {
                    $this->file_basename = $file->baseName;
                }
                if (!$this->file_extension || $this->file_extension == $this->getOldAttribute('file_extension')) {
                    $this->file_extension = $file->extension;
                }
            }

            if (!$this->name) {
                $this->name = $this->file_basename;
            }

            if ($this->audio_name_to_basename) {
                $this->file_basename = Inflector::slug($this->name);
            }

            if ($this->validate()) {
                $this->generatePath();
                if ($this->validate(['path'])) {
                    $old_origin_destination = $this->getOldLocation();
                    $origin_destination = $this->getLocation();

                    if (is_file($old_origin_destination)) {
                        if ($this->file_basename != $this->getOldAttribute('file_basename')
                            || $this->file_extension != $this->getOldAttribute('file_extension')
                            || $this->getDirectory() != $this->getOldDirectory()
                        ) {
                            copy($old_origin_destination, $origin_destination);
                            unlink($old_origin_destination);
                        }
                    }

                    if ($file) {
                        $new_audio_saved = $file->saveAs($this->getLocation());
                    }

                    if (!isset($new_audio_saved) || $new_audio_saved) {

                        if (is_file($alias = $this->getOldLocation())) {
                            unlink($alias);
                        }

                        if (is_file($origin_destination)) {
                            //
                        }

                        $dir = $this->getDirectory();
                        $old_dir = $this->getOldDirectory();
                        if ($dir != $old_dir && FileHelper::isEmptyDirectory($old_dir)) {
                            FileHelper::removeDirectory($old_dir);
                        }

                        if ($this->save()) {
                            return true;
                        }
                    }

                    if (isset($new_audio_saved) && !$new_audio_saved) {
                        $this->addError('audio_file', Yii::t('app', 'Cannot save audio or file is not audio.'));
                    }
                }
            }
        }
        return false;
    }

    public function getDirectory()
    {
        return Yii::getAlias("@audios/$this->path");
    }

    public function getOldDirectory()
    {
        return Yii::getAlias("@audios/{$this->getOldAttribute('path')}");
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
        $dir = Yii::getAlias("@audios/$this->path");
        if (!file_exists($dir)) {
            FileHelper::createDirectory($dir);
        }
    }

    public function getSource()
    {
        $path = $this->path;
        $basename = $this->file_basename;
        $extension = $this->file_extension;
        if ($path && $basename && $extension) {
            return Yii::getAlias("@audiosUrl/{$path}$basename.$extension");
        }
        return '';
    }

    public function getLocation()
    {
        $path = $this->path;
        $basename = $this->file_basename;
        $extension = $this->file_extension;
        if ($path && $basename && $extension) {
            return Yii::getAlias("@audios/{$path}$basename.$extension");
        }
        return '';
    }

    public function getOldLocation()
    {
        $path = $this->getOldAttribute('path');
        $basename = $this->getOldAttribute('file_basename');
        $extension = $this->getOldAttribute('file_extension');
        if ($path && $basename && $extension) {
            return Yii::getAlias("@audios/{$path}$basename.$extension");
        }
        return '';
    }

}