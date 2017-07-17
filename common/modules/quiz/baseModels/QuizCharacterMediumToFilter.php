<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz_character_medium_to_filter".
 *
 * @property integer $quiz_character_medium_id
 * @property integer $quiz_filter_id
 *
 * @property QuizCharacterMedium $quizCharacterMedium
 * @property QuizFilter $quizFilter
 */
class QuizCharacterMediumToFilter extends BaseQuiz
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_character_medium_to_filter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quiz_character_medium_id', 'quiz_filter_id'], 'required'],
            [['quiz_character_medium_id', 'quiz_filter_id'], 'integer'],
            [['quiz_character_medium_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizCharacterMedium::className(), 'targetAttribute' => ['quiz_character_medium_id' => 'id'], 'except' => 'test'],
            [['quiz_filter_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizFilter::className(), 'targetAttribute' => ['quiz_filter_id' => 'id'], 'except' => 'test'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'quiz_character_medium_id' => 'Quiz Character Medium ID',
            'quiz_filter_id' => 'Quiz Filter ID',
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
    public function getQuizFilter()
    {
        return $this->hasOne(QuizFilter::className(), ['id' => 'quiz_filter_id']);
    }
}
