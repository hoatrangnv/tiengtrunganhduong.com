<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz_input_to_validator".
 *
 * @property integer $quiz_input_id
 * @property integer $quiz_validator_id
 *
 * @property QuizInput $quizInput
 * @property QuizValidator $quizValidator
 */
class QuizInputToValidator extends BaseQuiz
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_input_to_validator';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quiz_input_id', 'quiz_validator_id'], 'required'],
            [['quiz_input_id', 'quiz_validator_id'], 'integer'],
            [['quiz_input_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizInput::className(), 'targetAttribute' => ['quiz_input_id' => 'id'], 'except' => 'test'],
            [['quiz_validator_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizValidator::className(), 'targetAttribute' => ['quiz_validator_id' => 'id'], 'except' => 'test'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'quiz_input_id' => 'Quiz Input ID',
            'quiz_validator_id' => 'Quiz Validator ID',
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
    public function getQuizValidator()
    {
        return $this->hasOne(QuizValidator::className(), ['id' => 'quiz_validator_id']);
    }
}
