<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz_character_medium_to_style".
 *
 * @property integer $quiz_character_medium_id
 * @property integer $quiz_style_id
 * @property integer $style_order
 *
 * @property QuizCharacterMedium $quizCharacterMedium
 * @property QuizStyle $quizStyle
 */
class QuizCharacterMediumToStyle extends BaseQuiz
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_character_medium_to_style';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quiz_character_medium_id', 'quiz_style_id', 'style_order'], 'required'],
            [['quiz_character_medium_id', 'quiz_style_id', 'style_order'], 'integer'],
            [['quiz_character_medium_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizCharacterMedium::className(), 'targetAttribute' => ['quiz_character_medium_id' => 'id'], 'except' => 'test'],
            [['quiz_style_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizStyle::className(), 'targetAttribute' => ['quiz_style_id' => 'id'], 'except' => 'test'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'quiz_character_medium_id' => 'Quiz Character Medium ID',
            'quiz_style_id' => 'Quiz Style ID',
            'style_order' => 'Style Order',
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
    public function getQuizStyle()
    {
        return $this->hasOne(QuizStyle::className(), ['id' => 'quiz_style_id']);
    }
}
