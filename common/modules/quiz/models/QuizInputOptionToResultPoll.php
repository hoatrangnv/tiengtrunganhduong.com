<?php

namespace common\modules\quiz\models;

use Yii;

/**
 * This is the model class for table "quiz_input_option_to_result_poll".
 *
 * @property integer $id
 * @property integer $votes
 * @property integer $result_id
 * @property integer $input_option_id
 *
 * @property QuizInputOption $inputOption
 * @property QuizResult $result
 */
class QuizInputOptionToResultPoll extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_input_option_to_result_poll';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['votes', 'result_id', 'input_option_id'], 'required'],
            [['votes', 'result_id', 'input_option_id'], 'integer'],
            [['input_option_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizInputOption::className(), 'targetAttribute' => ['input_option_id' => 'id']],
            [['result_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizResult::className(), 'targetAttribute' => ['result_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'votes' => 'Votes',
            'result_id' => 'Result ID',
            'input_option_id' => 'Input Option ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInputOption()
    {
        return $this->hasOne(QuizInputOption::className(), ['id' => 'input_option_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResult()
    {
        return $this->hasOne(QuizResult::className(), ['id' => 'result_id']);
    }
}
