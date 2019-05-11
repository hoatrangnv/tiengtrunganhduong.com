<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 3/31/2017
 * Time: 2:47 AM
 */

namespace backend\controllers;

use common\models\Image;
use common\models\Audio;
use Yii;
use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\web\Controller;
use backend\models\UploadForm;
use yii\web\Response;
use yii\web\UploadedFile;

class UploadController extends BaseController
{
    public function beforeAction($action)
    {
        // With some actions
        if (in_array($action->id, ['ckeditor-image', 'ckeditor-file'])) {
            // @TODO: Retrieve CSRF token via GET method
            $token = Yii::$app->request->get(Yii::$app->request->csrfParam);
            if (Yii::$app->request->validateCsrfToken($token)) {
                $this->enableCsrfValidation = false;
            }
        }
        return parent::beforeAction($action);
    }

    public function actionFile()
    {
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
                    Yii::$app->session->setFlash('error', '<div>Upload was fail:</div>' . $unsaved);
                }
            } else {
                Yii::$app->session->setFlash('error', '<div>Upload was fail:</div>' . VarDumper::dumpAsString($model->errors));
            }
        }

        return $this->render('images', ['model' => $model]);
    }

    public function actionAudios()
    {
        $model = new UploadForm();

        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {
            $model->audio_files = UploadedFile::getInstances($model, 'audio_files');
            if ($audios = $model->uploadAudios()) {
                // file is uploaded successfully

                if (count($audios['saved']) > 0) {
                    $saved = '<ul>';
                    foreach ($audios['saved'] as $audio) {
                        /**
                         * @var $audio Audio
                         */
                        $saved .= "<li><a href='{$audio->getSource()}' target='_blank'>$audio->name</a></li>";
                    }
                    $saved .= '</ul>';
                    Yii::$app->session->setFlash('success', '<div>Uploaded Successfully:</div>' . $saved);
                }

                if (count($audios['unsaved']) > 0) {
                    $unsaved = '<ul>';
                    foreach ($audios['unsaved'] as $audio) {
                        /**
                         * @var $audio Audio
                         */
                        $unsaved .= "<li><a href='{$audio->getSource()}' target='_blank'>$audio->name</a></li>";
                    }
                    $unsaved .= '</ul>';
                    Yii::$app->session->setFlash('error', '<div>Upload was fail:</div>' . $unsaved);
                }
            } else {
                Yii::$app->session->setFlash('error', '<div>Upload was fail:</div>' . VarDumper::dumpAsString($model->errors));
            }
        }

        return $this->render('audios', ['model' => $model]);
    }



    public function actionCkeditorImage()
    {
        $module = Yii::$app->getModule('image2');

        $funcNum = (string) Yii::$app->request->get('CKEditorFuncNum');
        $funcNum = preg_replace('/[^0-9]/', '', $funcNum);
//        $editor = Yii::$app->request->get('CKEditor');

        $file = UploadedFile::getInstanceByName('upload');
        $image = new Image();
        $image->active = 1;
        $image->quality = 60;
        $image->image_name_to_basename = true;
        $image->input_resize_keys = $module->params['input_resize_keys'];
        if ($image->saveFileAndModel($file)) {
            $errorMessage = '';
            $fileUrl = $image->getSource() . '?image_id=' . $image->id;
        } else {
            $errorMessage = Yii::t('app', "Image was not uploaded") . ': ';
            foreach ($image->getErrors() as $attr => $errors) {
                $errorMessage .=
                    "\n    $attr:\n        " .
                    implode("\n        ",
                        array_map(function ($error) {
                            return str_replace('"', "'", $error);
                        }, $errors)
                    );
            }
            $fileUrl = '';
        }
        ob_start();
        ?>
        <script type="text/javascript">
            /**
             * http://docs.cksource.com/CKEditor_3.x/Developers_Guide/File_Browser_(Uploader)/Custom_File_Browser
             */
            window.parent.CKEDITOR.tools.callFunction(<?php echo json_encode($funcNum); ?>, <?php echo json_encode($fileUrl); ?>, <?php echo json_encode($errorMessage); ?>);
        </script>
        <?php
    }

    public function actionAjaxImage()
    {
        $module = Yii::$app->getModule('image2');
        $file = UploadedFile::getInstanceByName('image_file');
        $image = new Image();
        $image->active = 1;
        $image->quality = 60;
        $image->input_resize_keys = $module->params['input_resize_keys'];
        if ($image->saveFileAndModel($file)) {
            return json_encode(['success' => true, 'image' => [
                'id' => $image->id,
                'name' => $image->name,
                'width' => $image->width,
                'height' => $image->height,
                'aspect_ratio' => $image->aspect_ratio,
                'source' => $image->getSource()
            ]]);
        } else {
            return json_encode(['success' => false, 'errors' => $image->getErrors()]);
        }
    }

    public function actionCkeditorFile()
    {

        $funcNum = (string) Yii::$app->request->get('CKEditorFuncNum');
        $funcNum = preg_replace('/[^0-9]/', '', $funcNum);
//        $editor = Yii::$app->request->get('CKEditor');

        $file = UploadedFile::getInstanceByName('upload');
        switch (0) {
            case strpos($file->type, 'audio/'):
                $audio = new Audio();
                $audio->audio_name_to_basename = true;
                if ($audio->saveFileAndModel($file)) {
                    $errorMessage = '';
                    $fileUrl = $audio->getSource() . '?audio_id=' . $audio->id;
                } else {
                    $errorMessage = Yii::t('app', "Audio was not uploaded") . ': ';
                    foreach ($audio->getErrors() as $attr => $errors) {
                        $errorMessage .=
                            "\n    $attr:\n        " .
                            implode("\n        ",
                                array_map(function ($error) {
                                    return str_replace('"', "'", $error);
                                }, $errors)
                            );
                    }
                    $fileUrl = '';
                }
                ob_start();
                ?>
                <script type="text/javascript">
                    /**
                     * http://docs.cksource.com/CKEditor_3.x/Developers_Guide/File_Browser_(Uploader)/Custom_File_Browser
                     */
                    window.parent.CKEDITOR.tools.callFunction(<?php echo json_encode($funcNum); ?>, <?php echo json_encode($fileUrl); ?>, <?php echo json_encode($errorMessage); ?>);
                </script>
                <?php
                break;
        }
    }
}