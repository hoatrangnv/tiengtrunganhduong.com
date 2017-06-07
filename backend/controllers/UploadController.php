<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 3/31/2017
 * Time: 2:47 AM
 */

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use backend\models\UploadForm;
use yii\web\UploadedFile;

class UploadController extends BaseController
{
    public function actionFile()
    {
        set_time_limit(600);
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->uploadFile()) {
                echo 'File is uploaded successfully';
                return true;
            }
        }

        return $this->render('file', ['model' => $model]);
    }

    public function actionImages()
    {
        $model = new UploadForm();

        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {
            $model->image_files = UploadedFile::getInstances($model, 'image_files');
            if ($images = $model->uploadImages()) {
                // file is uploaded successfully

                if (count($images['saved']) > 0) {
                    $saved = '<ul>';
                    foreach ($images['saved'] as $image) {
                        $saved .= "<li><a href='{$image->getSource()}' target='_blank'>$image->name</a></li>";
                    }
                    $saved .= '</ul>';
                    Yii::$app->session->setFlash('success', '<div>Uploaded Successfully:</div>' . $saved);
                }

                if (count($images['unsaved']) > 0) {
                    $unsaved = '<ul>';
                    foreach ($images['unsaved'] as $image) {
                        $unsaved .= "<li><a href='{$image->getSource()}' target='_blank'>$image->name</a></li>";
                    }
                    $unsaved .= '</ul>';
                    Yii::$app->session->setFlash('error', '<div>Uploaded fail:</div>' . $unsaved);
                }
            }
        }

        return $this->render('images', ['model' => $model]);
    }
}