<?php

namespace backend\controllers;

use Yii;
use backend\models\NameTranslation;
use backend\models\NameTranslationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * NameTranslationController implements the CRUD actions for NameTranslation model.
 */
class NameTranslationController extends Controller
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

    public function actionRemoveSpacesFromNameTranslationTable()
    {
        $total_count = 0;
        $w_count = 0;
        $t_count = 0;
        $s_count = 0;
        $saved_count = 0;
        foreach (NameTranslation::find()->where(['type' => NameTranslation::TYPE_FIRST_NAME])->all() as $nameTranslation) {
            $total_count++;
            /**
             * @var $nameTranslation NameTranslation
             */
            if (mb_strpos($nameTranslation->word, ' ') !== false) {
                $nameTranslation->word = str_replace(' ', '', $nameTranslation->word);
                $w_count++;
            }
            if (mb_strpos($nameTranslation->translated_word, ' ') !== false) {
                $nameTranslation->translated_word = str_replace(' ', '', $nameTranslation->translated_word);
                $t_count++;
            }
            if (mb_strpos($nameTranslation->spelling, ' ') !== false) {
                $nameTranslation->spelling = str_replace(' ', '', $nameTranslation->spelling);
                $s_count++;
            }
            if ($nameTranslation->save()) {
                $saved_count++;
            }
        }
        echo "\nTotal count = $total_count";
        echo "\nW count = $w_count";
        echo "\nT count = $t_count";
        echo "\nS count = $s_count";
        echo "\nSaved count = $saved_count";
    }

    /**
     * Lists all NameTranslation models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NameTranslationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single NameTranslation model.
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
     * Creates a new NameTranslation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new NameTranslation();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing NameTranslation model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing NameTranslation model.
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
     * Finds the NameTranslation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return NameTranslation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = NameTranslation::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
