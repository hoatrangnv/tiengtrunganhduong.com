<?php

namespace common\modules\quiz\models;

use Yii;

/**
 * This is the model class for table "quiz_filter".
 *
 * @property integer $id
 * @property string $name
 * @property string $condition
 * @property integer $quiz_id
 *
 * @property QuizCharacterMediumToFilter[] $characterMediumToFilters
 * @property QuizCharacterToFilter[] $characterToFilters
 * @property Quiz $quiz
 * @property QuizInputGroupToInputFilter[] $inputGroupToInputFilters
 * @property QuizInputToInputOptionFilter[] $inputToInputOptionFilters
 * @property QuizResultToCharacterMediumFilter[] $resultToCharacterMediumFilters
 * @property QuizResultToShapeFilter[] $resultToShapeFilters
 * @property QuizToCharacterFilter[] $quizToCharacterFilters
 * @property QuizToInputGroupFilter[] $quizToInputGroupFilters
 * @property QuizToResultFilter[] $quizToResultFilters
 */
class QuizFilter extends \yii\db\ActiveRecord
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
            [['name', 'condition'], 'required'],
            [['condition'], 'string'],
            [['quiz_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
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
            'condition' => 'Condition',
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
    public function getQuiz()
    {
        return $this->hasOne(Quiz::className(), ['id' => 'quiz_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInputGroupToInputFilters()
    {
        return $this->hasMany(QuizInputGroupToInputFilter::className(), ['filter_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInputToInputOptionFilters()
    {
        return $this->hasMany(QuizInputToInputOptionFilter::className(), ['filter_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResultToCharacterMediumFilters()
    {
        return $this->hasMany(QuizResultToCharacterMediumFilter::className(), ['filter_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResultToShapeFilters()
    {
        return $this->hasMany(QuizResultToShapeFilter::className(), ['filter_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizToCharacterFilters()
    {
        return $this->hasMany(QuizToCharacterFilter::className(), ['filter_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizToInputGroupFilters()
    {
        return $this->hasMany(QuizToInputGroupFilter::className(), ['filter_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizToResultFilters()
    {
        return $this->hasMany(QuizToResultFilter::className(), ['filter_id' => 'id']);
    }
}
