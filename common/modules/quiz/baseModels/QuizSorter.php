<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz_sorter".
 *
 * @property integer $id
 * @property string $name
 * @property string $rule_fn_args
 * @property integer $rule_fn_id
 * @property integer $quiz_id
 *
 * @property QuizCharacterMediumToSorter[] $characterMediumToSorters
 * @property QuizCharacterToSorter[] $characterToSorters
 * @property Quiz $quiz
 * @property QuizFn $ruleFn
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
            [['name', 'rule_fn_args', 'rule_fn_id'], 'required'],
            [['rule_fn_args'], 'string'],
            [['rule_fn_id', 'quiz_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['quiz_id'], 'exist', 'skipOnError' => true, 'targetClass' => Quiz::className(), 'targetAttribute' => ['quiz_id' => 'id']],
            [['rule_fn_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizFn::className(), 'targetAttribute' => ['rule_fn_id' => 'id']],
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
            'rule_fn_id' => 'Rule Fn ID',
            'quiz_id' => 'Quiz ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCharacterMediumToSorters()
    {
        return $this->hasMany(QuizCharacterMediumToSorter::className(), ['sorter_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCharacterToSorters()
    {
        return $this->hasMany(QuizCharacterToSorter::className(), ['sorter_id' => 'id']);
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
    public function getRuleFn()
    {
        return $this->hasOne(QuizFn::className(), ['id' => 'rule_fn_id']);
    }
}
