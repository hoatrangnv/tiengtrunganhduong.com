<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz_result_to_character_medium_to_style".
 *
 * @property integer $id
 * @property integer $style_order
 * @property integer $quiz_result_to_character_medium_id
 * @property integer $quiz_style_id
 *
 * @property QuizResultToCharacterMedium $quizResultToCharacterMedium
 * @property QuizStyle $quizStyle
 */
class QuizResultToCharacterMediumToStyle extends QuizBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_result_to_character_medium_to_style';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['style_order', 'quiz_result_to_character_medium_id', 'quiz_style_id'], 'integer'],
            [['quiz_result_to_character_medium_id', 'quiz_style_id'], 'required'],
            [['quiz_result_to_character_medium_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizResultToCharacterMedium::className(), 'targetAttribute' => ['quiz_result_to_character_medium_id' => 'id'], 'except' => 'test'],
            [['quiz_style_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizStyle::className(), 'targetAttribute' => ['quiz_style_id' => 'id'], 'except' => 'test'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'style_order' => 'Style Order',
            'quiz_result_to_character_medium_id' => 'Quiz Result To Character Medium ID',
            'quiz_style_id' => 'Quiz Style ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizResultToCharacterMedium()
    {
        return $this->hasOne(QuizResultToCharacterMedium::className(), ['id' => 'quiz_result_to_character_medium_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizStyle()
    {
        return $this->hasOne(QuizStyle::className(), ['id' => 'quiz_style_id']);
    }
}
