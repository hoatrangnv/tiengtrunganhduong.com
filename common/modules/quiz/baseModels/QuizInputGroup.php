<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz_input_group".
 *
 * @property integer $id
 * @property string $name
 * @property string $title
 * @property string $introduction
 * @property integer $duration
 * @property integer $task_order
 * @property integer $inputs_per_row
 * @property integer $inputs_per_small_row
 * @property string $inputs_appearance
 * @property integer $quiz_id
 *
 * @property QuizInput[] $quizInputs
 * @property Quiz $quiz
 */
class QuizInputGroup extends QuizBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_input_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'task_order', 'quiz_id'], 'required'],
            [['introduction'], 'string'],
            [['duration', 'task_order', 'inputs_per_row', 'inputs_per_small_row', 'quiz_id'], 'integer'],
            [['name', 'title', 'inputs_appearance'], 'string', 'max' => 255],
            [['quiz_id'], 'exist', 'skipOnError' => true, 'targetClass' => Quiz::className(), 'targetAttribute' => ['quiz_id' => 'id'], 'except' => 'test'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'title' => 'Title',
            'introduction' => 'Introduction',
            'duration' => 'Duration',
            'task_order' => 'Task Order',
            'inputs_per_row' => 'Inputs Per Row',
            'inputs_per_small_row' => 'Inputs Per Small Row',
            'inputs_appearance' => 'Inputs Appearance',
            'quiz_id' => 'Quiz ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizInputs()
    {
        return $this->hasMany(QuizInput::className(), ['quiz_input_group_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuiz()
    {
        return $this->hasOne(Quiz::className(), ['id' => 'quiz_id']);
    }
}
