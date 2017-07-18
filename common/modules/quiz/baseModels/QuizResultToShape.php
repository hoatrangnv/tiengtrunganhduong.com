<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz_result_to_shape".
 *
 * @property integer $quiz_result_id
 * @property integer $quiz_shape_id
 *
 * @property QuizResult $quizResult
 * @property QuizShape $quizShape
 */
class QuizResultToShape extends QuizBase
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
            [['quiz_result_id', 'quiz_shape_id'], 'required'],
            [['quiz_result_id', 'quiz_shape_id'], 'integer'],
            [['quiz_result_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizResult::className(), 'targetAttribute' => ['quiz_result_id' => 'id'], 'except' => 'test'],
            [['quiz_shape_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizShape::className(), 'targetAttribute' => ['quiz_shape_id' => 'id'], 'except' => 'test'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'quiz_result_id' => 'Quiz Result ID',
            'quiz_shape_id' => 'Quiz Shape ID',
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
    public function getQuizShape()
    {
        return $this->hasOne(QuizShape::className(), ['id' => 'quiz_shape_id']);
    }
}
