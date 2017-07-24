<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz_character_to_filter".
 *
 * @property integer $quiz_character_id
 * @property integer $quiz_filter_id
 *
 * @property QuizCharacter $quizCharacter
 * @property QuizFilter $quizFilter
 */
class QuizCharacterToFilter extends QuizBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_character_to_filter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quiz_character_id', 'quiz_filter_id'], 'required'],
            [['quiz_character_id', 'quiz_filter_id'], 'integer'],
            [['quiz_character_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizCharacter::className(), 'targetAttribute' => ['quiz_character_id' => 'id'], 'except' => 'test'],
            [['quiz_filter_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizFilter::className(), 'targetAttribute' => ['quiz_filter_id' => 'id'], 'except' => 'test'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'quiz_character_id' => 'Quiz Character ID',
            'quiz_filter_id' => 'Quiz Filter ID',
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
    public function getQuizFilter()
    {
        return $this->hasOne(QuizFilter::className(), ['id' => 'quiz_filter_id']);
    }
}
