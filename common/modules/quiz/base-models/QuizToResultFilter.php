<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz_to_result_filter".
 *
 * @property integer $id
 * @property integer $quiz_id
 * @property integer $result_filter_id
 *
 * @property Quiz $quiz
 * @property QuizFilter $resultFilter
 */
class QuizToResultFilter extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_to_result_filter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quiz_id', 'result_filter_id'], 'required'],
            [['quiz_id', 'result_filter_id'], 'integer'],
            [['quiz_id'], 'exist', 'skipOnError' => true, 'targetClass' => Quiz::className(), 'targetAttribute' => ['quiz_id' => 'id']],
            [['result_filter_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizFilter::className(), 'targetAttribute' => ['result_filter_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'quiz_id' => 'Quiz ID',
            'result_filter_id' => 'Result Filter ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuiz()
    {
        return $this->hasOne(Quiz::className(), ['id' => 'quiz_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResultFilter()
    {
        return $this->hasOne(QuizFilter::className(), ['id' => 'result_filter_id']);
    }
}
