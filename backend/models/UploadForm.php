<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile[]
     */
    public $imageFiles;

    public function rules()
    {
        return [
            [['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg, gif, PNG, JPG, JPEG, GIF', 'maxFiles' => 10],
        ];
    }

    public function uploadImages()
    {
        if ($this->validate()) {
            $images = [
                'saved' => [],
                'unsaved' => [],
            ];
            foreach ($this->imageFiles as $file) {
                $path = $this->getImagesPath();
                $destination = Yii::getAlias("@images/$path" . $file->name);

                $image = new Image();
                $image->name = $file->baseName;
                $image->path = $path;
                $image->mime_type = $file->type;
                $image->file_name = $file->name;
                $image->file_basename = $file->baseName;
                $image->file_extension = $file->extension;
                $image->active = 1;

                if ($image->validate() && $file->saveAs($destination) && $image->save()) {
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