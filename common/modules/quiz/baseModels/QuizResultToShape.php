<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz_result_to_shape".
 *
 * @property integer $id
 * @property integer $result_id
 * @property integer $shape_id
 *
 * @property QuizResult $result
 * @property QuizShape $shape
 * @property QuizResultToShapeToStyle[] $resultToShapeToStyles
 */
class QuizResultToShape extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_result_to_shape';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['result_id', 'shape_id'], 'required'],
            [['result_id', 'shape_id'], 'integer'],
            [['result_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizResult::className(), 'targetAttribute' => ['result_id' => 'id']],
            [['shape_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizShape::className(), 'targetAttribute' => ['shape_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'result_id' => 'Result ID',
            'shape_id' => 'Shape ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResult()
    {
        return $this->hasOne(QuizResult::className(), ['id' => 'result_id']);
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
    public function getResultToShapeToStyles()
    {
        return $this->hasMany(QuizResultToShapeToStyle::className(), ['result_to_shape_id' => 'id']);
    }
}
