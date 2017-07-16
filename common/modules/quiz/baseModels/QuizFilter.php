<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz_filter".
 *
 * @property integer $id
 * @property string $name
 * @property string $condition_fn_args
 * @property integer $quiz_condition_fn_id
 * @property integer $quiz_id
 *
 * @property QuizCharacterMediumToFilter[] $quizCharacterMediumToFilters
 * @property QuizCharacterToFilter[] $quizCharacterToFilters
 * @property QuizFn $quizConditionFn
 * @property Quiz $quiz
 * @property QuizInputGroupToInputFilter[] $quizInputGroupToInputFilters
 * @property QuizInputToInputOptionFilter[] $quizInputToInputOptionFilters
 * @property QuizResultToCharacterMediumFilter[] $quizResultToCharacterMediumFilters
 * @property QuizResultToShapeFilter[] $quizResultToShapeFilters
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
            [['name', 'condition_fn_args', 'quiz_condition_fn_id'], 'required'],
            [['condition_fn_args'], 'string'],
            [['quiz_condition_fn_id', 'quiz_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['quiz_condition_fn_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizFn::className(), 'targetAttribute' => ['quiz_condition_fn_id' => 'id'], 'except' => 'test'],
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
            'condition_fn_args' => 'Condition Fn Args',
            'quiz_condition_fn_id' => 'Quiz Condition Fn ID',
            'quiz_id' => 'Quiz ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizCharacterMediumToFilters()
    {
        return $this->hasMany(QuizCharacterMediumToFilter::className(), ['quiz_filter_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizCharacterToFilters()
    {
        return $this->hasMany(QuizCharacterToFilter::className(), ['quiz_filter_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizConditionFn()
    {
        return $this->hasOne(QuizFn::className(), ['id' => 'quiz_condition_fn_id']);
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
    public function getQuizInputGroupToInputFilters()
    {
        return $this->hasMany(QuizInputGroupToInputFilter::className(), ['quiz_input_filter_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizInputToInputOptionFilters()
    {
        return $this->hasMany(QuizInputToInputOptionFilter::className(), ['quiz_input_option_filter_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizResultToCharacterMediumFilters()
    {
        return $this->hasMany(QuizResultToCharacterMediumFilter::className(), ['quiz_character_medium_filter_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizResultToShapeFilters()
    {
        return $this->hasMany(QuizResultToShapeFilter::className(), ['quiz_shape_filter_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizToCharacterFilters()
    {
        return $this->hasMany(QuizToCharacterFilter::className(), ['quiz_character_filter_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizToInputGroupFilters()
    {
        return $this->hasMany(QuizToInputGroupFilter::className(), ['quiz_input_group_filter_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizToResultFilters()
    {
        return $this->hasMany(QuizToResultFilter::className(), ['quiz_result_filter_id' => 'id']);
    }
}
