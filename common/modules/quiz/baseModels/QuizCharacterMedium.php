<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz_character_medium".
 *
 * @property integer $id
 * @property string $name
 * @property string $var_name
 * @property string $type
 * @property string $index
 * @property integer $quiz_character_id
 * @property integer $width
 * @property integer $height
 *
 * @property QuizCharacter $quizCharacter
 * @property QuizCharacterMediumDataFilter[] $quizCharacterMediumDataFilters
 * @property QuizCharacterMediumDataSorter[] $quizCharacterMediumDataSorters
 * @property QuizCharacterMediumToStyle[] $quizCharacterMediumToStyles
 * @property QuizStyle[] $quizStyles
 * @property QuizResultToCharacterMedium[] $quizResultToCharacterMedia
 * @property QuizResult[] $quizResults
 */
class QuizCharacterMedium extends QuizBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_character_medium';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'var_name', 'type', 'index', 'quiz_character_id'], 'required'],
            [['quiz_character_id', 'width', 'height'], 'integer'],
            [['name', 'var_name', 'type', 'index'], 'string', 'max' => 255],
            [['quiz_character_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizCharacter::className(), 'targetAttribute' => ['quiz_character_id' => 'id'], 'except' => 'test'],
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
            'index' => 'Index',
            'quiz_character_id' => 'Quiz Character ID',
            'width' => 'Width',
            'height' => 'Height',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizCharacter()
    {
        return $this->hasOne(QuizCharacter::className(), ['id' => 'quiz_character_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizCharacterMediumDataFilters()
    {
        return $this->hasMany(QuizCharacterMediumDataFilter::className(), ['quiz_character_medium_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizCharacterMediumDataSorters()
    {
        return $this->hasMany(QuizCharacterMediumDataSorter::className(), ['quiz_character_medium_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizCharacterMediumToStyles()
    {
        return $this->hasMany(QuizCharacterMediumToStyle::className(), ['quiz_character_medium_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizStyles()
    {
        return $this->hasMany(QuizStyle::className(), ['id' => 'quiz_style_id'])->viaTable('quiz_character_medium_to_style', ['quiz_character_medium_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizResultToCharacterMedia()
    {
        return $this->hasMany(QuizResultToCharacterMedium::className(), ['quiz_character_medium_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizResults()
    {
        return $this->hasMany(QuizResult::className(), ['id' => 'quiz_result_id'])->viaTable('quiz_result_to_character_medium', ['quiz_character_medium_id' => 'id']);
    }
}
