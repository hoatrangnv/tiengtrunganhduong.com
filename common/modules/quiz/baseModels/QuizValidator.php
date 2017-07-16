<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz_validator".
 *
 * @property integer $id
 * @property string $name
 * @property string $validation_fn_args
 * @property integer $quiz_validation_fn_id
 * @property integer $quiz_id
 *
 * @property QuizInputToValidator[] $quizInputToValidators
 * @property Quiz $quiz
 * @property QuizFn $quizValidationFn
 */
class QuizValidator extends QuizBase
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
            [['name', 'validation_fn_args', 'quiz_validation_fn_id'], 'required'],
            [['validation_fn_args'], 'string'],
            [['quiz_validation_fn_id', 'quiz_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['quiz_id'], 'exist', 'skipOnError' => true, 'targetClass' => Quiz::className(), 'targetAttribute' => ['quiz_id' => 'id'], 'except' => 'test'],
            [['quiz_validation_fn_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizFn::className(), 'targetAttribute' => ['quiz_validation_fn_id' => 'id'], 'except' => 'test'],
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
            'quiz_validation_fn_id' => 'Quiz Validation Fn ID',
            'quiz_id' => 'Quiz ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizInputToValidators()
    {
        return $this->hasMany(QuizInputToValidator::className(), ['quiz_validator_id' => 'id']);
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
    public function getQuizValidationFn()
    {
        return $this->hasOne(QuizFn::className(), ['id' => 'quiz_validation_fn_id']);
    }
}
