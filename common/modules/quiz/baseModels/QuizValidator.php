<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz_validator".
 *
 * @property integer $id
 * @property string $name
 * @property string $validation_fn_args
 * @property integer $validation_fn_id
 * @property integer $quiz_id
 *
 * @property QuizInputToValidator[] $inputToValidators
 * @property Quiz $quiz
 * @property QuizFn $validationFn
 */
class QuizValidator extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_validator';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'validation_fn_args', 'validation_fn_id'], 'required'],
            [['validation_fn_args'], 'string'],
            [['validation_fn_id', 'quiz_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['quiz_id'], 'exist', 'skipOnError' => true, 'targetClass' => Quiz::className(), 'targetAttribute' => ['quiz_id' => 'id']],
            [['validation_fn_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizFn::className(), 'targetAttribute' => ['validation_fn_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'validation_fn_args' => 'Validation Fn Args',
            'validation_fn_id' => 'Validation Fn ID',
            'quiz_id' => 'Quiz ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInputToValidators()
    {
        return $this->hasMany(QuizInputToValidator::className(), ['validator_id' => 'id']);
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
    public function getValidationFn()
    {
        return $this->hasOne(QuizFn::className(), ['id' => 'validation_fn_id']);
    }
}
