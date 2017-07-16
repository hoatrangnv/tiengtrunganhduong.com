<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz_to_result_filter".
 *
 * @property integer $id
 * @property integer $quiz_id
 * @property integer $quiz_result_filter_id
 *
 * @property Quiz $quiz
 * @property QuizFilter $quizResultFilter
 */
class QuizToResultFilter extends QuizBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_to_result_filter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quiz_id', 'quiz_result_filter_id'], 'required'],
            [['quiz_id', 'quiz_result_filter_id'], 'integer'],
            [['quiz_id'], 'exist', 'skipOnError' => true, 'targetClass' => Quiz::className(), 'targetAttribute' => ['quiz_id' => 'id'], 'except' => 'test'],
            [['quiz_result_filter_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizFilter::className(), 'targetAttribute' => ['quiz_result_filter_id' => 'id'], 'except' => 'test'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'quiz_id' => 'Quiz ID',
            'quiz_result_filter_id' => 'Quiz Result Filter ID',
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
    public function getQuizResultFilter()
    {
        return $this->hasOne(QuizFilter::className(), ['id' => 'quiz_result_filter_id']);
    }
}
