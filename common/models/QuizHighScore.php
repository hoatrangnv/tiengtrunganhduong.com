<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "quiz_high_score".
 *
 * @property int $quiz_id
 * @property int $user_id
 * @property int $score
 * @property double $duration
 * @property int $time
 *
 * @property Quiz $quiz
 * @property User $user
 */
class QuizHighScore extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'quiz_high_score';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['quiz_id', 'user_id', 'score', 'time'], 'required'],
            [['quiz_id', 'user_id', 'score', 'time'], 'integer'],
            [['duration'], 'number'],
            [['quiz_id', 'user_id'], 'unique', 'targetAttribute' => ['quiz_id', 'user_id']],
            [['quiz_id'], 'exist', 'skipOnError' => true, 'targetClass' => Quiz::className(), 'targetAttribute' => ['quiz_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'quiz_id' => 'Quiz ID',
            'user_id' => 'User ID',
            'score' => 'Score',
            'duration' => 'Duration',
            'time' => 'Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuiz()
    {
        return $this->hasOne(Quiz::className(), ['id' => 'quiz_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
