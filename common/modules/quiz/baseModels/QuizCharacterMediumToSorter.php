<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz_character_medium_to_sorter".
 *
 * @property integer $id
 * @property integer $sorter_order
 * @property integer $quiz_character_medium_id
 * @property integer $quiz_sorter_id
 *
 * @property QuizCharacterMedium $quizCharacterMedium
 * @property QuizSorter $quizSorter
 */
class QuizCharacterMediumToSorter extends QuizBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_character_medium_to_sorter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sorter_order', 'quiz_character_medium_id', 'quiz_sorter_id'], 'integer'],
            [['quiz_character_medium_id', 'quiz_sorter_id'], 'required'],
            [['quiz_character_medium_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizCharacterMedium::className(), 'targetAttribute' => ['quiz_character_medium_id' => 'id'], 'except' => 'test'],
            [['quiz_sorter_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizSorter::className(), 'targetAttribute' => ['quiz_sorter_id' => 'id'], 'except' => 'test'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sorter_order' => 'Sorter Order',
            'quiz_character_medium_id' => 'Quiz Character Medium ID',
            'quiz_sorter_id' => 'Quiz Sorter ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizCharacterMedium()
    {
        return $this->hasOne(QuizCharacterMedium::className(), ['id' => 'quiz_character_medium_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizSorter()
    {
        return $this->hasOne(QuizSorter::className(), ['id' => 'quiz_sorter_id']);
    }
}
