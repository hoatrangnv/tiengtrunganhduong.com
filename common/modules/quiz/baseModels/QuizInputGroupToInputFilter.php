<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz_input_group_to_input_filter".
 *
 * @property integer $id
 * @property integer $quiz_input_group_id
 * @property integer $quiz_input_filter_id
 *
 * @property QuizFilter $quizInputFilter
 * @property QuizInputGroup $quizInputGroup
 */
class QuizInputGroupToInputFilter extends QuizBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_input_group_to_input_filter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quiz_input_group_id', 'quiz_input_filter_id'], 'required'],
            [['quiz_input_group_id', 'quiz_input_filter_id'], 'integer'],
            [['quiz_input_filter_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizFilter::className(), 'targetAttribute' => ['quiz_input_filter_id' => 'id'], 'except' => 'test'],
            [['quiz_input_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizInputGroup::className(), 'targetAttribute' => ['quiz_input_group_id' => 'id'], 'except' => 'test'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'quiz_input_group_id' => 'Quiz Input Group ID',
            'quiz_input_filter_id' => 'Quiz Input Filter ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizInputFilter()
    {
        return $this->hasOne(QuizFilter::className(), ['id' => 'quiz_input_filter_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizInputGroup()
    {
        return $this->hasOne(QuizInputGroup::className(), ['id' => 'quiz_input_group_id']);
    }
}
