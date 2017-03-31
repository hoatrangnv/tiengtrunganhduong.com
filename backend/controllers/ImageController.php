<?php

namespace backend\controllers;

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
class ImageController extends Controller
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
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
                $image_sizes = Image::getSizes();

                if (!is_array($model->image_resize_labels)) {
                    if ($model->image_resize_labels && is_string($model->image_resize_labels)) {
                        $model->image_resize_labels = implode(',', $model->image_resize_labels);
                    } else {
                        $model->image_resize_labels = [];
                    }
                }

                if ($model->image_name_to_basename) {
                    $model->file_basename = Inflector::slug(MyStringHelper::stripUnicode($model->name));
                }

                $model->file_name = "$model->file_basename.$model->file_extension";

                if (is_file($alias = $model->getOldLocation())) {
                    unlink($alias);
                }
                foreach ($model->getOldResizeLabels() as $old_size_label) {
                    if (is_file($alias = $model->getOldLocation($old_size_label))) {
                        unlink($alias);
                    }
                }

                $old_origin_destination = $model->getOldLocation(Image::LABEL_ORIGIN);
                $origin_destination = $model->getLocation(Image::LABEL_ORIGIN);
                $destination = $model->getLocation();

                if (is_file($old_origin_destination)) {
                    if ($model->file_basename != $model->getOldAttribute('file_basename')
                        || $model->file_extension != $model->getOldAttribute('file_extension')
                    ) {
                        copy($old_origin_destination, $origin_destination);
                        unlink($old_origin_destination);
                    }

                    $thumb0 = ImagineImage::getImagine()->open($origin_destination);
                    $thumb0->save($destination, ['quality' => $model->image_quality]);
                    foreach ($model->image_resize_labels as $size_label) {
                        if (isset($image_sizes[$size_label])) {
                            $size = $image_sizes[$size_label];
                            $dimension = explode('x', $size);
                            if ($model->image_crop) {
                                $thumb = ImagineImage::getImagine()->open($origin_destination)
                                    ->thumbnail(new Box($dimension[0], $dimension[1]), ManipulatorInterface::THUMBNAIL_OUTBOUND)
                                    ->crop(new Point(0, 0), new Box($dimension[0], $dimension[1]));
                            } else {
                                $thumb = ImagineImage::getImagine()->open($origin_destination)
                                    ->thumbnail(new Box($dimension[0], $dimension[1]));
                            }
                            $suffix = preg_replace(
                                ['/{w}/', '/{h}/'],
                                [$thumb->getSize()->getWidth(), $thumb->getSize()->getHeight()],
                                Image::LABEL_SIZE
                            );
                            if ($thumb->save($model->getLocation($suffix), ['quality' => $model->image_quality])) {
                                $resize_labels[$size_label] = $suffix;
                            }
                        }
                    }
                    $model->resize_labels = json_encode($resize_labels);
                }

                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
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
            if (is_file($origin = $model->getLocation(Image::LABEL_ORIGIN))) {
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
