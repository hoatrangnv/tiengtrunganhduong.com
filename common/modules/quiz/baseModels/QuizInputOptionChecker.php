<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz_input_option_checker".
 *
 * @property integer $id
 * @property string $name
 * @property string $arguments
 * @property integer $quiz_fn_id
 * @property integer $quiz_input_option_id
 *
 * @property QuizFn $quizFn
 * @property QuizInputOption $quizInputOption
 */
class QuizInputOptionChecker extends QuizBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_input_option_checker';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['arguments', 'quiz_fn_id', 'quiz_input_option_id'], 'required'],
            [['quiz_fn_id', 'quiz_input_option_id'], 'integer'],
            [['name', 'arguments'], 'string', 'max' => 255],
            [['quiz_fn_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizFn::className(), 'targetAttribute' => ['quiz_fn_id' => 'id'], 'except' => 'test'],
            [['quiz_input_option_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizInputOption::className(), 'targetAttribute' => ['quiz_input_option_id' => 'id'], 'except' => 'test'],
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
            'arguments' => 'Arguments',
            'quiz_fn_id' => 'Quiz Fn ID',
            'quiz_input_option_id' => 'Quiz Input Option ID',
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
    public function getQuizInputOption()
    {
        return $this->hasOne(QuizInputOption::className(), ['id' => 'quiz_input_option_id']);
    }
}
