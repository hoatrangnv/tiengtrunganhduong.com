<?php

namespace common\modules\audio\controllers;

use Yii;
use common\modules\audio\models\Audio;
use common\modules\audio\searchModels\Audio as AudioSearch;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AudioController implements the CRUD actions for Audio model.
 */
class AudioController extends Controller
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
     * Lists all Audio models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AudioSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Audio model.
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
     * Creates a new Audio model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Audio();

        if ($model->load(Yii::$app->request->post())) {
            $model->scenario = null;
            if ($model->saveFileAndModel()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        if ($model->hasErrors()) {
            Yii::$app->session->setFlash('error', VarDumper::dumpAsString($model->getErrors()));
        }
        $model->scenario = 'form';
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Audio model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->scenario = null;
            if ($model->updateFileAndModel()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        if ($model->hasErrors()) {
            Yii::$app->session->setFlash('error', VarDumper::dumpAsString($model->getErrors()));
        }
        $model->scenario = 'form';
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Audio model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Audio model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Audio the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Audio::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
