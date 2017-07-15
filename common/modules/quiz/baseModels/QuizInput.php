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
 * @property integer $input_group_id
 *
 * @property QuizInputGroup $inputGroup
 * @property QuizInputOption[] $inputOptions
 * @property QuizInputToInputOptionFilter[] $inputToInputOptionFilters
 * @property QuizInputToValidator[] $inputToValidators
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
            [['var_name', 'type', 'input_group_id'], 'required'],
            [['question', 'hint'], 'string'],
            [['row', 'column', 'input_group_id'], 'integer'],
            [['var_name', 'type'], 'string', 'max' => 255],
            [['input_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizInputGroup::className(), 'targetAttribute' => ['input_group_id' => 'id']],
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
            'input_group_id' => 'Input Group ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInputGroup()
    {
        return $this->hasOne(QuizInputGroup::className(), ['id' => 'input_group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInputOptions()
    {
        return $this->hasMany(QuizInputOption::className(), ['input_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInputToInputOptionFilters()
    {
        return $this->hasMany(QuizInputToInputOptionFilter::className(), ['input_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInputToValidators()
    {
        return $this->hasMany(QuizInputToValidator::className(), ['input_id' => 'id']);
    }
}
