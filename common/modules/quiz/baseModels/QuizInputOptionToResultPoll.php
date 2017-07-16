<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz_input_option_to_result_poll".
 *
 * @property integer $id
 * @property integer $votes
 * @property integer $quiz_result_id
 * @property integer $quiz_input_option_id
 *
 * @property QuizInputOption $quizInputOption
 * @property QuizResult $quizResult
 */
class QuizInputOptionToResultPoll extends QuizBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_input_option_to_result_poll';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['votes', 'quiz_result_id', 'quiz_input_option_id'], 'required'],
            [['votes', 'quiz_result_id', 'quiz_input_option_id'], 'integer'],
            [['quiz_input_option_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizInputOption::className(), 'targetAttribute' => ['quiz_input_option_id' => 'id'], 'except' => 'test'],
            [['quiz_result_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizResult::className(), 'targetAttribute' => ['quiz_result_id' => 'id'], 'except' => 'test'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'votes' => 'Votes',
            'quiz_result_id' => 'Quiz Result ID',
            'quiz_input_option_id' => 'Quiz Input Option ID',
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
    public function getQuizResult()
    {
        return $this->hasOne(QuizResult::className(), ['id' => 'quiz_result_id']);
    }
}
