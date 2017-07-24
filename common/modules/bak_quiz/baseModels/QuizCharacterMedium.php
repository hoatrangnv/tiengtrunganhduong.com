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
 * @property integer $index
 * @property integer $global_exec_order
 * @property integer $quiz_character_id
 *
 * @property QuizCharacter $quizCharacter
 * @property QuizCharacterMediumToFilter[] $quizCharacterMediumToFilters
 * @property QuizFilter[] $quizFilters
 * @property QuizCharacterMediumToSorter[] $quizCharacterMediumToSorters
 * @property QuizSorter[] $quizSorters
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
            [['name', 'var_name', 'type', 'index', 'global_exec_order', 'quiz_character_id'], 'required'],
            [['index', 'global_exec_order', 'quiz_character_id'], 'integer'],
            [['name', 'var_name', 'type'], 'string', 'max' => 255],
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
            'global_exec_order' => 'Global Exec Order',
            'quiz_character_id' => 'Quiz Character ID',
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
    public function getQuizCharacterMediumToFilters()
    {
        return $this->hasMany(QuizCharacterMediumToFilter::className(), ['quiz_character_medium_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizFilters()
    {
        return $this->hasMany(QuizFilter::className(), ['id' => 'quiz_filter_id'])->viaTable('quiz_character_medium_to_filter', ['quiz_character_medium_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizCharacterMediumToSorters()
    {
        return $this->hasMany(QuizCharacterMediumToSorter::className(), ['quiz_character_medium_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizSorters()
    {
        return $this->hasMany(QuizSorter::className(), ['id' => 'quiz_sorter_id'])->viaTable('quiz_character_medium_to_sorter', ['quiz_character_medium_id' => 'id']);
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
