<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz_object_filter".
 *
 * @property integer $id
 * @property string $name
 * @property string $affected_object_type
 * @property integer $task_order
 * @property string $arguments
 * @property integer $quiz_fn_id
 * @property integer $quiz_id
 *
 * @property QuizFn $quizFn
 * @property Quiz $quiz
 */
class QuizObjectFilter extends QuizBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_object_filter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'affected_object_type', 'task_order', 'arguments', 'quiz_fn_id', 'quiz_id'], 'required'],
            [['task_order', 'quiz_fn_id', 'quiz_id'], 'integer'],
            [['name', 'affected_object_type', 'arguments'], 'string', 'max' => 255],
            [['quiz_fn_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizFn::className(), 'targetAttribute' => ['quiz_fn_id' => 'id'], 'except' => 'test'],
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
            'affected_object_type' => 'Affected Object Type',
            'task_order' => 'Task Order',
            'arguments' => 'Arguments',
            'quiz_fn_id' => 'Quiz Fn ID',
            'quiz_id' => 'Quiz ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizFn()
    {
        return $this->hasOne(QuizFn::className(), ['id' => 'quiz_fn_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuiz()
    {
        return $this->hasOne(Quiz::className(), ['id' => 'quiz_id']);
    }
}
