<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 8/25/2018
 * Time: 10:54 AM
 */

namespace frontend\controllers;


use frontend\models\QuizHighScore;
use frontend\models\User;
use InvalidArgumentException;
use Yii;
use yii\helpers\ArrayHelper;
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

        $quiz_id = $req->post('quiz_id');
        $score = $req->post('score');
        $duration = $req->post('duration');
        $result_limit = $req->post('result_limit', 10);
        $start_time = $req->post('start_time');
        $end_time = $req->post('end_time');

        if ($quiz_id === null) {
            throw new InvalidArgumentException('`quiz_id` is required.');
        }

        if ($score === null) {
            throw new InvalidArgumentException('`score` is required.');
        }

        $quizHighScore = new QuizHighScore();
        $quizHighScore->quiz_id = $quiz_id;
        $quizHighScore->user_id = $user->id;
        $quizHighScore->score = +$score;
        $quizHighScore->duration = +$duration;
        $quizHighScore->time = time();

        $oldQuizHighScore = QuizHighScore::findOne(['quiz_id' => $quiz_id, 'user_id' => $user->id]);

        if ($oldQuizHighScore) {
            if ($quizHighScore->score > $oldQuizHighScore->score
                || (
                    $quizHighScore->score === $oldQuizHighScore->score
                    && $quizHighScore->duration < $oldQuizHighScore->duration
                )
            ) {
                $oldQuizHighScore->score = $quizHighScore->score;
                $oldQuizHighScore->duration = $quizHighScore->duration;
                $oldQuizHighScore->time = $quizHighScore->time;

                $oldQuizHighScore->save();
            }
        } else {
            $quizHighScore->save();
        }

        $query = QuizHighScore::find()
            ->where(['quiz_id' => $quiz_id])
            ->orderBy('score DESC, duration ASC, time DESC')
            ->limit($result_limit);

        if ($start_time) {
            $query->andWhere(['>=', 'time', strtotime($start_time)]);
        }

        if ($end_time) {
            $query->andWhere(['<=', 'time', strtotime($start_time)]);
        }

        $quizHighScores = $query->all();

        return array_map(function ($item) {
            /**
             * @var QuizHighScore $item
             */
            $user = $item->user;
            return [
                'user' => [
                    'id' => $user->id,
                    'name' => "$user->last_name $user->first_name",
                    'picture_url' => 'http://graph.facebook.com/'
                        . str_replace('fbu.', '', $user->username)
                        . '/picture?width=50&height=50',
                ],
                'score' => $item->score,
                'duration' => $item->duration,
                'formattedTime' => date('d/m/Y H:i:s', $item->time),
                'time' => $item->time
            ];
        }, $quizHighScores);

    }

    public function actionGetHighScoreResult()
    {
        if (!Yii::$app->request->isPost) {
            throw new BadRequestHttpException('Request must be POST.');
        }

        $req = Yii::$app->request;

        $quiz_id = $req->post('quiz_id');
        $result_limit = $req->post('result_limit', 10);
        $start_time = $req->post('start_time');
        $end_time = $req->post('end_time');

        if ($quiz_id === null) {
            throw new InvalidArgumentException('`quiz_id` is required.');
        }

        $query = QuizHighScore::find()
            ->where(['quiz_id' => $quiz_id])
            ->orderBy('score DESC, duration ASC, time DESC')
            ->limit($result_limit);

        if ($start_time) {
            $query->andWhere(['>=', 'time', strtotime($start_time)]);
        }

        if ($end_time) {
            $query->andWhere(['<=', 'time', strtotime($start_time)]);
        }

        $quizHighScores = $query->all();

        return array_map(function ($item) {
            /**
             * @var QuizHighScore $item
             */
            $user = $item->user;
            return [
                'user' => [
                    'id' => $user->id,
                    'name' => "$user->last_name $user->first_name",
                    'picture_url' => 'http://graph.facebook.com/'
                        . str_replace('fbu.', '', $user->username)
                        . '/picture?width=50&height=50',
                ],
                'score' => $item->score,
                'duration' => $item->duration,
                'formattedTime' => date('d/m/Y H:i:s', $item->time),
                'time' => $item->time
            ];
        }, $quizHighScores);

    }
}