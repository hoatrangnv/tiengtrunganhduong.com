<?php

namespace common\modules\quiz\models;

use Yii;

/**
 * This is the model class for table "quiz_to_input_group_filter".
 *
 * @property integer $id
 * @property integer $quiz_id
 * @property integer $input_group_filter_id
 *
 * @property QuizFilter $inputGroupFilter
 * @property Quiz $quiz
 */
class QuizToInputGroupFilter extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_to_input_group_filter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quiz_id', 'input_group_filter_id'], 'required'],
            [['quiz_id', 'input_group_filter_id'], 'integer'],
            [['input_group_filter_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizFilter::className(), 'targetAttribute' => ['input_group_filter_id' => 'id']],
            [['quiz_id'], 'exist', 'skipOnError' => true, 'targetClass' => Quiz::className(), 'targetAttribute' => ['quiz_id' => 'id']],
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
            'input_group_filter_id' => 'Input Group Filter ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInputGroupFilter()
    {
        return $this->hasOne(QuizFilter::className(), ['id' => 'input_group_filter_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuiz()
    {
        return $this->hasOne(Quiz::className(), ['id' => 'quiz_id']);
    }
}
