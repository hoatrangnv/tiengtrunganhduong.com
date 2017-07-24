<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz_input_to_input_validator".
 *
 * @property integer $quiz_input_id
 * @property integer $quiz_input_validator_id
 *
 * @property QuizInput $quizInput
 * @property QuizInputValidator $quizInputValidator
 */
class QuizInputToInputValidator extends QuizBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_input_to_input_validator';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quiz_input_id', 'quiz_input_validator_id'], 'required'],
            [['quiz_input_id', 'quiz_input_validator_id'], 'integer'],
            [['quiz_input_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizInput::className(), 'targetAttribute' => ['quiz_input_id' => 'id'], 'except' => 'test'],
            [['quiz_input_validator_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizInputValidator::className(), 'targetAttribute' => ['quiz_input_validator_id' => 'id'], 'except' => 'test'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'quiz_input_id' => 'Quiz Input ID',
            'quiz_input_validator_id' => 'Quiz Input Validator ID',
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
    public function getQuizInputValidator()
    {
        return $this->hasOne(QuizInputValidator::className(), ['id' => 'quiz_input_validator_id']);
    }
}
