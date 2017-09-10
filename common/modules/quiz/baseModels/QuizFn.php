<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz_fn".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $parameters
 * @property string $body
 * @property string $return_type
 * @property integer $async
 * @property string $guideline
 *
 * @property QuizCharacterDataFilter[] $quizCharacterDataFilters
 * @property QuizCharacterDataSorter[] $quizCharacterDataSorters
 * @property QuizCharacterMediumDataFilter[] $quizCharacterMediumDataFilters
 * @property QuizCharacterMediumDataSorter[] $quizCharacterMediumDataSorters
 * @property QuizInputOptionChecker[] $quizInputOptionCheckers
 * @property QuizInputValidator[] $quizInputValidators
 * @property QuizObjectFilter[] $quizObjectFilters
 * @property QuizParam[] $quizParams
 */
class QuizFn extends QuizBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_fn';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'parameters', 'body', 'return_type'], 'required'],
            [['body', 'guideline'], 'string'],
            [['async'], 'integer'],
            [['name', 'parameters', 'return_type'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 511],
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
            'description' => 'Description',
            'parameters' => 'Parameters',
            'body' => 'Body',
            'return_type' => 'Return Type',
            'async' => 'Async',
            'guideline' => 'Guideline',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizCharacterDataFilters()
    {
        return $this->hasMany(QuizCharacterDataFilter::className(), ['quiz_fn_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizCharacterDataSorters()
    {
        return $this->hasMany(QuizCharacterDataSorter::className(), ['quiz_fn_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizCharacterMediumDataFilters()
    {
        return $this->hasMany(QuizCharacterMediumDataFilter::className(), ['quiz_fn_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizCharacterMediumDataSorters()
    {
        return $this->hasMany(QuizCharacterMediumDataSorter::className(), ['quiz_fn_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizInputOptionCheckers()
    {
        return $this->hasMany(QuizInputOptionChecker::className(), ['quiz_fn_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizInputValidators()
    {
        return $this->hasMany(QuizInputValidator::className(), ['quiz_fn_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizObjectFilters()
    {
        return $this->hasMany(QuizObjectFilter::className(), ['quiz_fn_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizParams()
    {
        return $this->hasMany(QuizParam::className(), ['quiz_fn_id' => 'id']);
    }
}
