<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz_input_group".
 *
 * @property integer $id
 * @property string $name
 * @property string $title
 * @property integer $global_exec_order
 * @property integer $quiz_id
 *
 * @property QuizInput[] $quizInputs
 * @property Quiz $quiz
 * @property QuizInputGroupToInputFilter[] $quizInputGroupToInputFilters
 * @property QuizFilter[] $quizInputFilters
 */
class QuizInputGroup extends BaseQuiz
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
            [['name', 'global_exec_order', 'quiz_id'], 'required'],
            [['global_exec_order', 'quiz_id'], 'integer'],
            [['name', 'title'], 'string', 'max' => 255],
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
            'global_exec_order' => 'Global Exec Order',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizInputGroupToInputFilters()
    {
        return $this->hasMany(QuizInputGroupToInputFilter::className(), ['quiz_input_group_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizInputFilters()
    {
        return $this->hasMany(QuizFilter::className(), ['id' => 'quiz_input_filter_id'])->viaTable('quiz_input_group_to_input_filter', ['quiz_input_group_id' => 'id']);
    }
}
