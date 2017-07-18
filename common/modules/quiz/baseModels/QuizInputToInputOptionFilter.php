<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz_input_to_input_option_filter".
 *
 * @property integer $quiz_input_id
 * @property integer $quiz_input_option_filter_id
 *
 * @property QuizInput $quizInput
 * @property QuizFilter $quizInputOptionFilter
 */
class QuizInputToInputOptionFilter extends QuizBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_input_to_input_option_filter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quiz_input_id', 'quiz_input_option_filter_id'], 'required'],
            [['quiz_input_id', 'quiz_input_option_filter_id'], 'integer'],
            [['quiz_input_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizInput::className(), 'targetAttribute' => ['quiz_input_id' => 'id'], 'except' => 'test'],
            [['quiz_input_option_filter_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizFilter::className(), 'targetAttribute' => ['quiz_input_option_filter_id' => 'id'], 'except' => 'test'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'quiz_input_id' => 'Quiz Input ID',
            'quiz_input_option_filter_id' => 'Quiz Input Option Filter ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizInput()
    {
        return $this->hasOne(QuizInput::className(), ['id' => 'quiz_input_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizInputOptionFilter()
    {
        return $this->hasOne(QuizFilter::className(), ['id' => 'quiz_input_option_filter_id']);
    }
}
