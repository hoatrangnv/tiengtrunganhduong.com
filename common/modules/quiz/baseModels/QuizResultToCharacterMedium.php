<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz_result_to_character_medium".
 *
 * @property integer $quiz_result_id
 * @property integer $quiz_character_medium_id
 *
 * @property QuizCharacterMedium $quizCharacterMedium
 * @property QuizResult $quizResult
 */
class QuizResultToCharacterMedium extends BaseQuiz
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_result_to_character_medium';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quiz_result_id', 'quiz_character_medium_id'], 'required'],
            [['quiz_result_id', 'quiz_character_medium_id'], 'integer'],
            [['quiz_character_medium_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizCharacterMedium::className(), 'targetAttribute' => ['quiz_character_medium_id' => 'id'], 'except' => 'test'],
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
            'quiz_character_medium_id' => 'Quiz Character Medium ID',
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
    public function getQuizResult()
    {
        return $this->hasOne(QuizResult::className(), ['id' => 'quiz_result_id']);
    }
}
