<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz_input_validator".
 *
 * @property integer $id
 * @property string $name
 * @property string $arguments
 * @property integer $quiz_fn_id
 * @property integer $quiz_id
 *
 * @property QuizInputToInputValidator[] $quizInputToInputValidators
 * @property QuizInput[] $quizInputs
 * @property QuizFn $quizFn
 * @property Quiz $quiz
 */
class QuizInputValidator extends QuizBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_input_validator';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'arguments', 'quiz_fn_id'], 'required'],
            [['quiz_fn_id', 'quiz_id'], 'integer'],
            [['name', 'arguments'], 'string', 'max' => 255],
            [['quiz_fn_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizFn::className(), 'targetAttribute' => ['quiz_fn_id' => 'id'], 'except' => 'test'],
            [['quiz_id'], 'exist', 'skipOnError' => true, 'targetClass' => Quiz::className(), 'targetAttribute' => ['quiz_id' => 'id'], 'except' => 'test'],
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
            'arguments' => 'Arguments',
            'quiz_fn_id' => 'Quiz Fn ID',
            'quiz_id' => 'Quiz ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizInputToInputValidators()
    {
        return $this->hasMany(QuizInputToInputValidator::className(), ['quiz_input_validator_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizInputs()
    {
        return $this->hasMany(QuizInput::className(), ['id' => 'quiz_input_id'])->viaTable('quiz_input_to_input_validator', ['quiz_input_validator_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizFn()
    {
        return $this->hasOne(QuizFn::className(), ['id' => 'quiz_fn_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuiz()
    {
        return $this->hasOne(Quiz::className(), ['id' => 'quiz_id']);
    }
}
