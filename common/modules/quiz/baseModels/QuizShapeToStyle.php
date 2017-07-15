<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz_shape_to_style".
 *
 * @property integer $id
 * @property integer $style_order
 * @property integer $shape_id
 * @property integer $style_id
 *
 * @property QuizShape $shape
 * @property QuizStyle $style
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
            [['style_order', 'shape_id', 'style_id'], 'integer'],
            [['shape_id', 'style_id'], 'required'],
            [['shape_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizShape::className(), 'targetAttribute' => ['shape_id' => 'id']],
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
            'shape_id' => 'Shape ID',
            'style_id' => 'Style ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShape()
    {
        return $this->hasOne(QuizShape::className(), ['id' => 'shape_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStyle()
    {
        return $this->hasOne(QuizStyle::className(), ['id' => 'style_id']);
    }
}
