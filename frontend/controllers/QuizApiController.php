<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 8/25/2018
 * Time: 10:54 AM
 */

namespace frontend\controllers;


use common\models\QuizHighScore;
use frontend\models\User;
use InvalidArgumentException;
use Yii;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;

class QuizApiController extends Controller
{
    public function actionSaveHighScore()
    {
        if (!Yii::$app->request->isPost) {
            throw new BadRequestHttpException('Request must be POST.');
        }

        $req = Yii::$app->request;

        if (Yii::$app->user->isGuest) {
            throw new ForbiddenHttpException('You must be logged in to send this request.');
        }

        /**
         * @var $user User
         */
        $user = Yii::$app->user->identity;

        var_dump($req->post());
        die;

        $quiz_id = $req->post('quiz_id');
        $score = $req->post('score');
        $duration = $req->post('duration');

        if ($quiz_id === null) {
            throw new InvalidArgumentException('`quiz_id` is required.');
        }

        if ($score === null) {
            throw new InvalidArgumentException('`score` is required.');
        }

        $quizHighScore = new QuizHighScore();
        $quizHighScore->quiz_id = $quiz_id;
        $quizHighScore->user_id = $user->id;
        $quizHighScore->score = $score;
        $quizHighScore->duration = $duration;
        $quizHighScore->time = time();

        if ($quizHighScore->save()) {
            return [
                'status' => 'success',
                'data' => $quizHighScore->attributes
            ];
        } else {
            return [
                'status' => 'failure',
                'error' => $quizHighScore->errors
            ];
        }

    }
}