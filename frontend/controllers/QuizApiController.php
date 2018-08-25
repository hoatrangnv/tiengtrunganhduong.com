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

//                if ($oldQuizHighScore->save()) {
//                    return [
//                        'status' => 'succeed',
//                        'data' => $oldQuizHighScore->attributes
//                    ];
//                } else {
//                    return [
//                        'status' => 'fail',
//                        'error' => $oldQuizHighScore->errors
//                    ];
//                }
                $oldQuizHighScore->save();
            }
        } else {
//            if ($quizHighScore->save()) {
//                return [
//                    'status' => 'succeed',
//                    'data' => $quizHighScore->attributes
//                ];
//            } else {
//                return [
//                    'status' => 'fail',
//                    'error' => $quizHighScore->errors
//                ];
//            }
            $quizHighScore->save();
        }

//        return [
//            'status' => 'rejected',
//        ];

        $quizHighScores = QuizHighScore::find()
            ->where(['quiz_id' => $quiz_id])
            ->orderBy('score DESC, duration ASC, time DESC')
            ->limit($result_limit)
            ->all();

        return array_map(function ($item) {
            /**
             * @var QuizHighScore $item
             */
            return [
                'user' => $item->user->attributes,
                'score' => $item->score,
                'duration' => $item->duration,
                'formattedTime' => date('d/m/Y H:i:s', $item->time),
                'time' => $item->time
            ];
        }, $quizHighScores);

    }
}