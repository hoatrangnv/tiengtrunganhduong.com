<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz_sorter".
 *
 * @property integer $id
 * @property string $name
 * @property string $rule_fn_args
 * @property integer $quiz_rule_fn_id
 * @property integer $quiz_id
 *
 * @property QuizCharacterMediumToSorter[] $quizCharacterMediumToSorters
 * @property QuizCharacterToSorter[] $quizCharacterToSorters
 * @property Quiz $quiz
 * @property QuizFn $quizRuleFn
 */
class QuizSorter extends QuizBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_sorter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'rule_fn_args', 'quiz_rule_fn_id'], 'required'],
            [['rule_fn_args'], 'string'],
            [['quiz_rule_fn_id', 'quiz_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['quiz_id'], 'exist', 'skipOnError' => true, 'targetClass' => Quiz::className(), 'targetAttribute' => ['quiz_id' => 'id'], 'except' => 'test'],
            [['quiz_rule_fn_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizFn::className(), 'targetAttribute' => ['quiz_rule_fn_id' => 'id'], 'except' => 'test'],
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
            'rule_fn_args' => 'Rule Fn Args',
            'quiz_rule_fn_id' => 'Quiz Rule Fn ID',
            'quiz_id' => 'Quiz ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizCharacterMediumToSorters()
    {
        return $this->hasMany(QuizCharacterMediumToSorter::className(), ['quiz_sorter_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizCharacterToSorters()
    {
        return $this->hasMany(QuizCharacterToSorter::className(), ['quiz_sorter_id' => 'id']);
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
    public function getQuizRuleFn()
    {
        return $this->hasOne(QuizFn::className(), ['id' => 'quiz_rule_fn_id']);
    }
}
