<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 7/23/2017
 * Time: 3:28 AM
 */

namespace common\modules\quiz\controllers;


use yii\web\Controller;
use common\modules\quiz\models\Quiz;
use yii\web\NotFoundHttpException;

class PlayController extends Controller
{
    public function actionIndex($id)
    {
        $quiz = $this->findModel($id);
        $quizCharacters = $quiz->quizCharacters;
        $quizInputGroups = $quiz->quizInputGroups;
        $quizParams = $quiz->quizParams;

        return $this->render('index', [
            'quiz' => $quiz,
            'quizCharacters' => array_map(function ($item) { return $item->attributes; }, $quizCharacters),
            'quizInputGroups' => array_map(function ($item) { return $item->attributes; }, $quizInputGroups),
            'quizParams' => array_map(function ($item) { return $item->attributes; }, $quizParams),
//            'quizResults' => $quizResults,
        ]);
    }

    /**
     * Finds the Quiz model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Quiz the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Quiz::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}