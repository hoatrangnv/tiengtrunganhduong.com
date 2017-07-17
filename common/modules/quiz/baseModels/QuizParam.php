<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz_param".
 *
 * @property integer $id
 * @property string $name
 * @property string $var_name
 * @property string $value_fn_args
 * @property integer $quiz_value_fn_id
 * @property integer $global_exec_order
 * @property integer $quiz_id
 *
 * @property Quiz $quiz
 * @property QuizFn $quizValueFn
 */
class QuizParam extends BaseQuiz
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
            [['name', 'var_name', 'value_fn_args', 'quiz_value_fn_id', 'global_exec_order', 'quiz_id'], 'required'],
            [['value_fn_args'], 'string'],
            [['quiz_value_fn_id', 'global_exec_order', 'quiz_id'], 'integer'],
            [['name', 'var_name'], 'string', 'max' => 255],
            [['quiz_id'], 'exist', 'skipOnError' => true, 'targetClass' => Quiz::className(), 'targetAttribute' => ['quiz_id' => 'id'], 'except' => 'test'],
            [['quiz_value_fn_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizFn::className(), 'targetAttribute' => ['quiz_value_fn_id' => 'id'], 'except' => 'test'],
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
            'value_fn_args' => 'Value Fn Args',
            'quiz_value_fn_id' => 'Quiz Value Fn ID',
            'global_exec_order' => 'Global Exec Order',
            'quiz_id' => 'Quiz ID',
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
    public function getQuizValueFn()
    {
        return $this->hasOne(QuizFn::className(), ['id' => 'quiz_value_fn_id']);
    }
}
