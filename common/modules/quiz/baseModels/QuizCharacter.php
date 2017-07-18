<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz_character".
 *
 * @property integer $id
 * @property string $name
 * @property string $var_name
 * @property string $type
 * @property integer $index
 * @property integer $global_exec_order
 * @property integer $quiz_id
 *
 * @property Quiz $quiz
 * @property QuizCharacterMedium[] $quizCharacterMedia
 * @property QuizCharacterToFilter[] $quizCharacterToFilters
 * @property QuizFilter[] $quizFilters
 * @property QuizCharacterToSorter[] $quizCharacterToSorters
 * @property QuizSorter[] $quizSorters
 */
class QuizCharacter extends QuizBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_character';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'var_name', 'type', 'index', 'global_exec_order', 'quiz_id'], 'required'],
            [['index', 'global_exec_order', 'quiz_id'], 'integer'],
            [['name', 'var_name', 'type'], 'string', 'max' => 255],
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
            'var_name' => 'Var Name',
            'type' => 'Type',
            'index' => 'Index',
            'global_exec_order' => 'Global Exec Order',
            'quiz_id' => 'Quiz ID',
        ];
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
    public function getQuizCharacterMedia()
    {
        return $this->hasMany(QuizCharacterMedium::className(), ['quiz_character_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizCharacterToFilters()
    {
        return $this->hasMany(QuizCharacterToFilter::className(), ['quiz_character_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizFilters()
    {
        return $this->hasMany(QuizFilter::className(), ['id' => 'quiz_filter_id'])->viaTable('quiz_character_to_filter', ['quiz_character_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizCharacterToSorters()
    {
        return $this->hasMany(QuizCharacterToSorter::className(), ['quiz_character_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizSorters()
    {
        return $this->hasMany(QuizSorter::className(), ['id' => 'quiz_sorter_id'])->viaTable('quiz_character_to_sorter', ['quiz_character_id' => 'id']);
    }
}
