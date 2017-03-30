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

class UploadController extends Controller
{
    public function actionImages()
    {
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
            if ($images = $model->uploadImages()) {
                // file is uploaded successfully
                $saved = '<ul>';
                foreach ($images['saved'] as $image) {
                    $saved .= "<li><a href='{$image->getSource()}' target='_blank'>$image->name</a></li>";
                }
                $saved .= '</ul>';

                $unsaved = '<ul>';
                foreach ($images['unsaved'] as $image) {
                    $unsaved .= "<li><a href='{$image->getSource()}' target='_blank'>$image->name</a></li>";
                }
                $unsaved .= '</ul>';

                if (count($images['saved']) > 0) {
                    Yii::$app->session->setFlash('success', '<div>Uploaded Successfully:</div>' . $saved);
                }

                if (count($images['unsaved']) > 0) {
                    Yii::$app->session->setFlash('error', '<div>Uploaded fail:</div>' . $unsaved);
                }
            }
        }

        return $this->render('images', ['model' => $model]);
    }
}