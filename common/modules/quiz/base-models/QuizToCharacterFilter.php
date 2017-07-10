<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz_to_character_filter".
 *
 * @property integer $id
 * @property integer $quiz_id
 * @property integer $character_filter_id
 *
 * @property QuizFilter $characterFilter
 * @property Quiz $quiz
 */
class QuizToCharacterFilter extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_to_character_filter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quiz_id', 'character_filter_id'], 'required'],
            [['quiz_id', 'character_filter_id'], 'integer'],
            [['character_filter_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizFilter::className(), 'targetAttribute' => ['character_filter_id' => 'id']],
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
            'quiz_id' => 'Quiz ID',
            'character_filter_id' => 'Character Filter ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCharacterFilter()
    {
        return $this->hasOne(QuizFilter::className(), ['id' => 'character_filter_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuiz()
    {
        return $this->hasOne(Quiz::className(), ['id' => 'quiz_id']);
    }
}
