<?php

namespace common\modules\quiz\models;

use Yii;

/**
 * This is the model class for table "quiz_result_to_shape_filter".
 *
 * @property integer $id
 * @property integer $result_id
 * @property integer $filter_id
 *
 * @property QuizFilter $filter
 * @property QuizResult $result
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
            [['result_id', 'filter_id'], 'required'],
            [['result_id', 'filter_id'], 'integer'],
            [['filter_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizFilter::className(), 'targetAttribute' => ['filter_id' => 'id']],
            [['result_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizResult::className(), 'targetAttribute' => ['result_id' => 'id']],
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
            'filter_id' => 'Filter ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFilter()
    {
        return $this->hasOne(QuizFilter::className(), ['id' => 'filter_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResult()
    {
        return $this->hasOne(QuizResult::className(), ['id' => 'result_id']);
    }
}
