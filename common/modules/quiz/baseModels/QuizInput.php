<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz_input".
 *
 * @property integer $id
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
 * @property QuizInputToInputOptionFilter[] $quizInputToInputOptionFilters
 * @property QuizFilter[] $quizInputOptionFilters
 * @property QuizInputToValidator[] $quizInputToValidators
 * @property QuizValidator[] $quizValidators
 */
class QuizInput extends BaseQuiz
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
            [['var_name', 'type', 'quiz_input_group_id'], 'required'],
            [['question', 'hint'], 'string'],
            [['row', 'column', 'quiz_input_group_id'], 'integer'],
            [['var_name', 'type'], 'string', 'max' => 255],
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
    public function getQuizInputToInputOptionFilters()
    {
        return $this->hasMany(QuizInputToInputOptionFilter::className(), ['quiz_input_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizInputOptionFilters()
    {
        return $this->hasMany(QuizFilter::className(), ['id' => 'quiz_input_option_filter_id'])->viaTable('quiz_input_to_input_option_filter', ['quiz_input_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizInputToValidators()
    {
        return $this->hasMany(QuizInputToValidator::className(), ['quiz_input_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizValidators()
    {
        return $this->hasMany(QuizValidator::className(), ['id' => 'quiz_validator_id'])->viaTable('quiz_input_to_validator', ['quiz_input_id' => 'id']);
    }
}
