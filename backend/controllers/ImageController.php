<?php

namespace backend\controllers;

use common\helpers\MyFileHelper;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Yii;
use backend\models\Image;
use backend\models\ImageSearch;
use yii\helpers\FileHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\imagine\Image as ImagineImage;
use Imagine\Gd;
use Imagine\Image\Box;
use Imagine\Image\BoxInterface;
use common\helpers\MyStringHelper;
use Imagine\Image\ManipulatorInterface;
use Imagine\Image\Point;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\helpers\Inflector;
use yii\helpers\VarDumper;
use yii\web\UploadedFile;

/**
 * ImageController implements the CRUD actions for Image model.
 */
class ImageController extends BaseController
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Image models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ImageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Image model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Image model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Image();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate(['image_file', 'image_source'])) {
                $resize_labels = [];
                $model->castValueToArray('image_resize_labels');

                if (!$file = $model->getImageSourceAsUploadedFile()) {
                    $file = UploadedFile::getInstance($model, 'image_file');
                }

                if ($file) {
                    $model->mime_type = $file->type;
                    $model->name = $model->name ? $model->name : $file->baseName;

                    if ($model->image_name_to_basename) {
                        $model->file_basename = Inflector::slug(MyStringHelper::stripUnicode($model->name));
                    } else {
                        $model->file_basename = $file->baseName;
                    }
                    if (!$model->file_extension) {
                        $model->file_extension = $file->extension;
                    }

                    $model->file_name = "$model->file_basename.$model->file_extension";

                    // @TODO: Save origin image
                    $model->generatePath();
                    $origin_destination = $model->getLocation(Image::SIZE_ORIGIN_LABEL);
//                    if ($file->saveAs($origin_destination)) {
                    if (MyFileHelper::moveImage($file->tempName, $origin_destination, true)) {
                        // @TODO: Save cropped and compressed images
                        $destination = $model->getLocation();
                        $thumb0 = ImagineImage::getImagine()->open($origin_destination);

                        if ($model->validate()) {
                            try {
                                $thumb0->save($destination, ['quality' => $model->image_quality]);
                                foreach ($model->image_resize_labels as $size_label) {
                                    if ($dimension = $model->getSizeFromSizeKey($size_label)) {
                                        if ($model->image_crop) {
                                            $thumb = ImagineImage::getImagine()->open($origin_destination)
                                                ->thumbnail(new Box($dimension[0], $dimension[1]), ManipulatorInterface::THUMBNAIL_OUTBOUND)
                                                ->crop(new Point(0, 0), new Box($dimension[0], $dimension[1]));
                                        } else {
                                            $thumb = ImagineImage::getImagine()->open($origin_destination)
                                                ->thumbnail(new Box($dimension[0], $dimension[1]));
                                        }
                                        $suffix = $model->getResizeLabelFromSize([$thumb->getSize()->getWidth(), $thumb->getSize()->getHeight()]);
                                        if ($thumb->save($model->getLocation($suffix), ['quality' => $model->image_quality])) {
                                            $resize_labels[$size_label] = $suffix;
                                        }
                                    }
                                }
                                $model->resize_labels = json_encode($resize_labels);
                                if ($model->save()) {
                                    return $this->redirect(['view', 'id' => $model->id]);
                                }
                            } catch (\Exception $e) {
                                $model->addError($model->image_source ? 'image_source' : 'image_file',
                                    Yii::t('app', $e->getMessage()));
                            }
                        }

                    } else {
                        $model->addError($model->image_source ? 'image_source' : 'image_file',
                            Yii::t('app', 'Cannot save image or file is not image.'));
                    }
                }
            }

            Yii::$app->session->setFlash('error', VarDumper::dumpAsString($model->errors));

        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Image model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $resize_labels = [];
                $model->castValueToArray('image_resize_labels');

                if (!$file = $model->getImageSourceAsUploadedFile()) {
                    $file = UploadedFile::getInstance($model, 'image_file');
                }

                if ($file) {
                    if (!$model->file_basename || $model->file_basename == $model->getOldAttribute('file_basename')) {
                        $model->file_basename = $file->baseName;
                    }
                    if (!$model->file_extension || $model->file_extension == $model->getOldAttribute('file_extension')) {
                        $model->file_extension = $file->extension;
                    }
                }

                if ($model->image_name_to_basename) {
                    $model->file_basename = Inflector::slug(MyStringHelper::stripUnicode($model->name));
                }

                $model->file_name = "$model->file_basename.$model->file_extension";

                if ($model->validate()) {
                    $model->generatePath();
                    if ($model->validate(['path'])) {
                        $old_origin_destination = $model->getOldLocation(Image::SIZE_ORIGIN_LABEL);
                        $origin_destination = $model->getLocation(Image::SIZE_ORIGIN_LABEL);
                        $destination = $model->getLocation();

                        if (is_file($old_origin_destination)) {
                            if ($model->file_basename != $model->getOldAttribute('file_basename')
                                || $model->file_extension != $model->getOldAttribute('file_extension')
                                || $model->getDirectory() != $model->getOldDirectory()
                            ) {
                                copy($old_origin_destination, $origin_destination);
                                unlink($old_origin_destination);
                            }
                        }

                        if ($file) {
//                            $file->saveAs($model->getLocation(Image::SIZE_ORIGIN_LABEL));
                            $new_image_saved = MyFileHelper::moveImage($file->tempName,
                                $model->getLocation(Image::SIZE_ORIGIN_LABEL), true);

                        }

                        if (!isset($new_image_saved) || $new_image_saved) {

                            if (is_file($alias = $model->getOldLocation())) {
                                unlink($alias);
                            }
                            foreach ($model->getOldResizeLabels() as $old_size_label) {
                                if (is_file($alias = $model->getOldLocation($old_size_label))) {
                                    unlink($alias);
                                }
                            }

                            if (is_file($origin_destination)) {
                                $thumb0 = ImagineImage::getImagine()->open($origin_destination);
                                $thumb0->save($destination, ['quality' => $model->image_quality]);
                                foreach ($model->image_resize_labels as $size_label) {
                                    if ($dimension = $model->getSizeFromSizeKey($size_label)) {
                                        if ($model->image_crop) {
                                            $thumb = ImagineImage::getImagine()->open($origin_destination)
                                                ->thumbnail(new Box($dimension[0], $dimension[1]), ManipulatorInterface::THUMBNAIL_OUTBOUND)
                                                ->crop(new Point(0, 0), new Box($dimension[0], $dimension[1]));
                                        } else {
                                            $thumb = ImagineImage::getImagine()->open($origin_destination)
                                                ->thumbnail(new Box($dimension[0], $dimension[1]));
                                        }
                                        $suffix = $model->getResizeLabelFromSize([$thumb->getSize()->getWidth(), $thumb->getSize()->getHeight()]);
                                        if ($thumb->save($model->getLocation($suffix), ['quality' => $model->image_quality])) {
                                            $resize_labels[$size_label] = $suffix;
                                        }
                                    }
                                }
                                $model->resize_labels = json_encode($resize_labels);
                            }

                            $dir = $model->getDirectory();
                            $old_dir = $model->getOldDirectory();
                            if ($dir != $old_dir && MyFileHelper::isEmptyDirectory($old_dir)) {
                                FileHelper::removeDirectory($old_dir);
                            }

                            if ($model->save()) {
                                return $this->redirect(['view', 'id' => $model->id]);
                            }
                        }

                        if (isset($new_image_saved) && !$new_image_saved) {
                            $model->addError($model->image_source ? 'image_source' : 'image_file',
                                Yii::t('app', 'Cannot save image or file is not image.'));
                        }
                    }
                }
            }
            Yii::$app->session->setFlash('error', VarDumper::dumpAsString($model->errors));
        }

        $model->image_resize_labels = array_keys($model->getResizeLabels());

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Image model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->delete()) {
            if (is_file($origin = $model->getLocation(Image::SIZE_ORIGIN_LABEL))) {
                unlink($origin);
            }
            if (is_file($default = $model->getLocation())) {
                unlink($default);
            }
            foreach ($model->getResizeLabels() as $resize_label) {
                if (is_file($resized = $model->getLocation($resize_label))) {
                    unlink($resized);
                }
            }
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Image model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Image the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Image::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
