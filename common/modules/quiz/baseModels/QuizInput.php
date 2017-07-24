<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz_input".
 *
 * @property integer $id
 * @property string $name
 * @property string $var_name
 * @property string $type
 * @property string $question
 * @property string $hint
 * @property integer $row
 * @property integer $column
 * @property integer $quiz_input_group_id
 *
 * @property QuizInputGroup $quizInputGroup
 * @property QuizInputOption[] $quizInputOptions
 * @property QuizInputToInputValidator[] $quizInputToInputValidators
 * @property QuizInputValidator[] $quizInputValidators
 */
class QuizInput extends QuizBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_input';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'var_name', 'type', 'quiz_input_group_id'], 'required'],
            [['question', 'hint'], 'string'],
            [['row', 'column', 'quiz_input_group_id'], 'integer'],
            [['name', 'var_name', 'type'], 'string', 'max' => 255],
            [['quiz_input_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizInputGroup::className(), 'targetAttribute' => ['quiz_input_group_id' => 'id'], 'except' => 'test'],
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
            'var_name' => 'Var Name',
            'type' => 'Type',
            'question' => 'Question',
            'hint' => 'Hint',
            'row' => 'Row',
            'column' => 'Column',
            'quiz_input_group_id' => 'Quiz Input Group ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizInputGroup()
    {
        return $this->hasOne(QuizInputGroup::className(), ['id' => 'quiz_input_group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizInputOptions()
    {
        return $this->hasMany(QuizInputOption::className(), ['quiz_input_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizInputToInputValidators()
    {
        return $this->hasMany(QuizInputToInputValidator::className(), ['quiz_input_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizInputValidators()
    {
        return $this->hasMany(QuizInputValidator::className(), ['id' => 'quiz_input_validator_id'])->viaTable('quiz_input_to_input_validator', ['quiz_input_id' => 'id']);
    }
}
