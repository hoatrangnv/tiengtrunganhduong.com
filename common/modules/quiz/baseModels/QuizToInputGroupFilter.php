<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz_to_input_group_filter".
 *
 * @property integer $quiz_id
 * @property integer $quiz_input_group_filter_id
 *
 * @property Quiz $quiz
 * @property QuizFilter $quizInputGroupFilter
 */
class QuizToInputGroupFilter extends BaseQuiz
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_to_input_group_filter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quiz_id', 'quiz_input_group_filter_id'], 'required'],
            [['quiz_id', 'quiz_input_group_filter_id'], 'integer'],
            [['quiz_id'], 'exist', 'skipOnError' => true, 'targetClass' => Quiz::className(), 'targetAttribute' => ['quiz_id' => 'id'], 'except' => 'test'],
            [['quiz_input_group_filter_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizFilter::className(), 'targetAttribute' => ['quiz_input_group_filter_id' => 'id'], 'except' => 'test'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'quiz_id' => 'Quiz ID',
            'quiz_input_group_filter_id' => 'Quiz Input Group Filter ID',
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
    public function getQuizInputGroupFilter()
    {
        return $this->hasOne(QuizFilter::className(), ['id' => 'quiz_input_group_filter_id']);
    }
}
