<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz_shape_to_style".
 *
 * @property integer $quiz_shape_id
 * @property integer $quiz_style_id
 * @property integer $style_order
 *
 * @property QuizShape $quizShape
 * @property QuizStyle $quizStyle
 */
class QuizShapeToStyle extends BaseQuiz
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_shape_to_style';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quiz_shape_id', 'quiz_style_id', 'style_order'], 'required'],
            [['quiz_shape_id', 'quiz_style_id', 'style_order'], 'integer'],
            [['quiz_shape_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizShape::className(), 'targetAttribute' => ['quiz_shape_id' => 'id'], 'except' => 'test'],
            [['quiz_style_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizStyle::className(), 'targetAttribute' => ['quiz_style_id' => 'id'], 'except' => 'test'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'quiz_shape_id' => 'Quiz Shape ID',
            'quiz_style_id' => 'Quiz Style ID',
            'style_order' => 'Style Order',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizShape()
    {
        return $this->hasOne(QuizShape::className(), ['id' => 'quiz_shape_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizStyle()
    {
        return $this->hasOne(QuizStyle::className(), ['id' => 'quiz_style_id']);
    }
}
