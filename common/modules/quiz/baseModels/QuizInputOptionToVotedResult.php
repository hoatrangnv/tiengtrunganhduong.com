<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz_input_option_to_voted_result".
 *
 * @property integer $quiz_input_option_id
 * @property integer $quiz_voted_result_id
 * @property integer $votes
 *
 * @property QuizInputOption $quizInputOption
 * @property QuizResult $quizVotedResult
 */
class QuizInputOptionToVotedResult extends QuizBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_input_option_to_voted_result';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quiz_input_option_id', 'quiz_voted_result_id', 'votes'], 'required'],
            [['quiz_input_option_id', 'quiz_voted_result_id', 'votes'], 'integer'],
            [['quiz_input_option_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizInputOption::className(), 'targetAttribute' => ['quiz_input_option_id' => 'id'], 'except' => 'test'],
            [['quiz_voted_result_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizResult::className(), 'targetAttribute' => ['quiz_voted_result_id' => 'id'], 'except' => 'test'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'quiz_input_option_id' => 'Quiz Input Option ID',
            'quiz_voted_result_id' => 'Quiz Voted Result ID',
            'votes' => 'Votes',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizInputOption()
    {
        return $this->hasOne(QuizInputOption::className(), ['id' => 'quiz_input_option_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizVotedResult()
    {
        return $this->hasOne(QuizResult::className(), ['id' => 'quiz_voted_result_id']);
    }
}
