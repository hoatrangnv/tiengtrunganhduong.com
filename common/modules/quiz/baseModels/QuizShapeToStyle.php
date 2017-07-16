<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz_shape_to_style".
 *
 * @property integer $id
 * @property integer $style_order
 * @property integer $quiz_shape_id
 * @property integer $quiz_style_id
 *
 * @property QuizShape $quizShape
 * @property QuizStyle $quizStyle
 */
class QuizShapeToStyle extends QuizBase
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
            [['style_order', 'quiz_shape_id', 'quiz_style_id'], 'integer'],
            [['quiz_shape_id', 'quiz_style_id'], 'required'],
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
            'id' => 'ID',
            'style_order' => 'Style Order',
            'quiz_shape_id' => 'Quiz Shape ID',
            'quiz_style_id' => 'Quiz Style ID',
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
