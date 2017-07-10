<?php

namespace common\modules\quiz\models;

use Yii;

/**
 * This is the model class for table "quiz_result_to_shape_to_style".
 *
 * @property integer $id
 * @property integer $style_order
 * @property integer $result_to_shape_id
 * @property integer $style_id
 *
 * @property QuizResultToShape $resultToShape
 * @property QuizStyle $style
 */
class QuizResultToShapeToStyle extends \yii\db\ActiveRecord
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
            [['style_order', 'result_to_shape_id', 'style_id'], 'integer'],
            [['result_to_shape_id', 'style_id'], 'required'],
            [['result_to_shape_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizResultToShape::className(), 'targetAttribute' => ['result_to_shape_id' => 'id']],
            [['style_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizStyle::className(), 'targetAttribute' => ['style_id' => 'id']],
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
            'result_to_shape_id' => 'Result To Shape ID',
            'style_id' => 'Style ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResultToShape()
    {
        return $this->hasOne(QuizResultToShape::className(), ['id' => 'result_to_shape_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStyle()
    {
        return $this->hasOne(QuizStyle::className(), ['id' => 'style_id']);
    }
}
