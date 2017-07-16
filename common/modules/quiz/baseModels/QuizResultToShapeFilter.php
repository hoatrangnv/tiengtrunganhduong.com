<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz_result_to_shape_filter".
 *
 * @property integer $id
 * @property integer $quiz_result_id
 * @property integer $quiz_shape_filter_id
 *
 * @property QuizResult $quizResult
 * @property QuizFilter $quizShapeFilter
 */
class QuizResultToShapeFilter extends QuizBase
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
            [['quiz_result_id', 'quiz_shape_filter_id'], 'required'],
            [['quiz_result_id', 'quiz_shape_filter_id'], 'integer'],
            [['quiz_result_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizResult::className(), 'targetAttribute' => ['quiz_result_id' => 'id'], 'except' => 'test'],
            [['quiz_shape_filter_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizFilter::className(), 'targetAttribute' => ['quiz_shape_filter_id' => 'id'], 'except' => 'test'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'quiz_result_id' => 'Quiz Result ID',
            'quiz_shape_filter_id' => 'Quiz Shape Filter ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizResult()
    {
        return $this->hasOne(QuizResult::className(), ['id' => 'quiz_result_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizShapeFilter()
    {
        return $this->hasOne(QuizFilter::className(), ['id' => 'quiz_shape_filter_id']);
    }
}
