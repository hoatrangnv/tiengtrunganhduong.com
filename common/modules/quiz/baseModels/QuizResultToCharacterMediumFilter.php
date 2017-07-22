<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz_result_to_character_medium_filter".
 *
 * @property integer $quiz_result_id
 * @property integer $quiz_character_medium_filter_id
 *
 * @property QuizFilter $quizCharacterMediumFilter
 * @property QuizResult $quizResult
 */
class QuizResultToCharacterMediumFilter extends QuizBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_result_to_character_medium_filter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quiz_result_id', 'quiz_character_medium_filter_id'], 'required'],
            [['quiz_result_id', 'quiz_character_medium_filter_id'], 'integer'],
            [['quiz_character_medium_filter_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizFilter::className(), 'targetAttribute' => ['quiz_character_medium_filter_id' => 'id'], 'except' => 'test'],
            [['quiz_result_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizResult::className(), 'targetAttribute' => ['quiz_result_id' => 'id'], 'except' => 'test'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'quiz_result_id' => 'Quiz Result ID',
            'quiz_character_medium_filter_id' => 'Quiz Character Medium Filter ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizCharacterMediumFilter()
    {
        return $this->hasOne(QuizFilter::className(), ['id' => 'quiz_character_medium_filter_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizResult()
    {
        return $this->hasOne(QuizResult::className(), ['id' => 'quiz_result_id']);
    }
}
