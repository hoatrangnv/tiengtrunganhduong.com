<?php

namespace backend\controllers;

use Yii;
use backend\models\QuizHighScore;
use backend\models\QuizHighScoreSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * QuizHighScoreController implements the CRUD actions for QuizHighScore model.
 */
class QuizHighScoreController extends Controller
{
    /**
     * {@inheritdoc}
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
     * Lists all QuizHighScore models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new QuizHighScoreSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single QuizHighScore model.
     * @param integer $quiz_id
     * @param integer $user_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($quiz_id, $user_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($quiz_id, $user_id),
        ]);
    }

    /**
     * Creates a new QuizHighScore model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new QuizHighScore();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'quiz_id' => $model->quiz_id, 'user_id' => $model->user_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing QuizHighScore model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $quiz_id
     * @param integer $user_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($quiz_id, $user_id)
    {
        $model = $this->findModel($quiz_id, $user_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'quiz_id' => $model->quiz_id, 'user_id' => $model->user_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing QuizHighScore model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $quiz_id
     * @param integer $user_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($quiz_id, $user_id)
    {
        $this->findModel($quiz_id, $user_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the QuizHighScore model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $quiz_id
     * @param integer $user_id
     * @return QuizHighScore the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($quiz_id, $user_id)
    {
        if (($model = QuizHighScore::findOne(['quiz_id' => $quiz_id, 'user_id' => $user_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
