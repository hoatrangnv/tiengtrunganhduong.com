<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz_result_to_shape_to_style".
 *
 * @property integer $id
 * @property integer $style_order
 * @property integer $quiz_result_to_shape_id
 * @property integer $quiz_style_id
 *
 * @property QuizResultToShape $quizResultToShape
 * @property QuizStyle $quizStyle
 */
class QuizResultToShapeToStyle extends QuizBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_result_to_shape_to_style';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['style_order', 'quiz_result_to_shape_id', 'quiz_style_id'], 'integer'],
            [['quiz_result_to_shape_id', 'quiz_style_id'], 'required'],
            [['quiz_result_to_shape_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizResultToShape::className(), 'targetAttribute' => ['quiz_result_to_shape_id' => 'id'], 'except' => 'test'],
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
            'quiz_result_to_shape_id' => 'Quiz Result To Shape ID',
            'quiz_style_id' => 'Quiz Style ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizResultToShape()
    {
        return $this->hasOne(QuizResultToShape::className(), ['id' => 'quiz_result_to_shape_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizStyle()
    {
        return $this->hasOne(QuizStyle::className(), ['id' => 'quiz_style_id']);
    }
}
