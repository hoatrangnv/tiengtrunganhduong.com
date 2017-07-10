<?php

namespace common\modules\quiz\models;

use Yii;

/**
 * This is the model class for table "quiz_result_to_shape_filter".
 *
 * @property integer $id
 * @property integer $result_id
 * @property integer $shape_filter_id
 *
 * @property QuizResult $result
 * @property QuizFilter $shapeFilter
 */
class QuizResultToShapeFilter extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_result_to_shape_filter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['result_id', 'shape_filter_id'], 'required'],
            [['result_id', 'shape_filter_id'], 'integer'],
            [['result_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizResult::className(), 'targetAttribute' => ['result_id' => 'id']],
            [['shape_filter_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizFilter::className(), 'targetAttribute' => ['shape_filter_id' => 'id']],
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
            'shape_filter_id' => 'Shape Filter ID',
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
    public function getShapeFilter()
    {
        return $this->hasOne(QuizFilter::className(), ['id' => 'shape_filter_id']);
    }
}
