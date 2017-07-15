<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz_filter".
 *
 * @property integer $id
 * @property string $name
 * @property string $condition_fn_args
 * @property integer $condition_fn_id
 * @property integer $quiz_id
 *
 * @property QuizCharacterMediumToFilter[] $characterMediumToFilters
 * @property QuizCharacterToFilter[] $characterToFilters
 * @property QuizFn $conditionFn
 * @property Quiz $quiz
 * @property QuizInputGroupToInputFilter[] $inputGroupToInputFilters
 * @property QuizInputToInputOptionFilter[] $inputToInputOptionFilters
 * @property QuizResultToCharacterMediumFilter[] $resultToCharacterMediumFilters
 * @property QuizResultToShapeFilter[] $resultToShapeFilters
 * @property QuizToCharacterFilter[] $quizToCharacterFilters
 * @property QuizToInputGroupFilter[] $quizToInputGroupFilters
 * @property QuizToResultFilter[] $quizToResultFilters
 */
class QuizFilter extends QuizBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_filter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'condition_fn_args', 'condition_fn_id'], 'required'],
            [['condition_fn_args'], 'string'],
            [['condition_fn_id', 'quiz_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['condition_fn_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizFn::className(), 'targetAttribute' => ['condition_fn_id' => 'id']],
            [['quiz_id'], 'exist', 'skipOnError' => true, 'targetClass' => Quiz::className(), 'targetAttribute' => ['quiz_id' => 'id']],
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
            'condition_fn_args' => 'Condition Fn Args',
            'condition_fn_id' => 'Condition Fn ID',
            'quiz_id' => 'Quiz ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCharacterMediumToFilters()
    {
        return $this->hasMany(QuizCharacterMediumToFilter::className(), ['filter_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCharacterToFilters()
    {
        return $this->hasMany(QuizCharacterToFilter::className(), ['filter_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConditionFn()
    {
        return $this->hasOne(QuizFn::className(), ['id' => 'condition_fn_id']);
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
    public function getInputGroupToInputFilters()
    {
        return $this->hasMany(QuizInputGroupToInputFilter::className(), ['input_filter_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInputToInputOptionFilters()
    {
        return $this->hasMany(QuizInputToInputOptionFilter::className(), ['input_option_filter_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResultToCharacterMediumFilters()
    {
        return $this->hasMany(QuizResultToCharacterMediumFilter::className(), ['character_medium_filter_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResultToShapeFilters()
    {
        return $this->hasMany(QuizResultToShapeFilter::className(), ['shape_filter_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizToCharacterFilters()
    {
        return $this->hasMany(QuizToCharacterFilter::className(), ['character_filter_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizToInputGroupFilters()
    {
        return $this->hasMany(QuizToInputGroupFilter::className(), ['input_group_filter_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizToResultFilters()
    {
        return $this->hasMany(QuizToResultFilter::className(), ['result_filter_id' => 'id']);
    }
}
