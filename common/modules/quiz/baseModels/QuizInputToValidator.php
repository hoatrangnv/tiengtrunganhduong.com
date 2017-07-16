<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz_input_to_validator".
 *
 * @property integer $id
 * @property integer $input_id
 * @property integer $validator_id
 *
 * @property QuizInput $input
 * @property QuizValidator $quizValidator
 */
class QuizInputToValidator extends QuizBase
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
            [['input_id', 'validator_id'], 'required'],
            [['input_id', 'validator_id'], 'integer'],
            [['input_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizInput::className(), 'targetAttribute' => ['input_id' => 'id']],
            [['validator_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizValidator::className(), 'targetAttribute' => ['validator_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'input_id' => 'Input ID',
            'validator_id' => 'Validator ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInput()
    {
        return $this->hasOne(QuizInput::className(), ['id' => 'input_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizValidator()
    {
        return $this->hasOne(QuizValidator::className(), ['id' => 'validator_id']);
    }
}
