<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz_param".
 *
 * @property integer $id
 * @property string $name
 * @property string $var_name
 * @property string $arguments
 * @property integer $quiz_fn_id
 * @property integer $task_order
 * @property integer $quiz_id
 *
 * @property QuizFn $quizFn
 * @property Quiz $quiz
 */
class QuizParam extends QuizBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_param';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'var_name', 'arguments', 'quiz_fn_id', 'task_order', 'quiz_id'], 'required'],
            [['quiz_fn_id', 'task_order', 'quiz_id'], 'integer'],
            [['name', 'var_name', 'arguments'], 'string', 'max' => 255],
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
            'var_name' => 'Var Name',
            'arguments' => 'Arguments',
            'quiz_fn_id' => 'Quiz Fn ID',
            'task_order' => 'Task Order',
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
