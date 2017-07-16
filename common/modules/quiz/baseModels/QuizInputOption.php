<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz_input_option".
 *
 * @property integer $id
 * @property string $value
 * @property string $content
 * @property integer $score
 * @property string $interpretation
 * @property integer $row
 * @property integer $column
 * @property integer $quiz_input_id
 *
 * @property QuizInput $quizInput
 * @property QuizInputOptionToResultPoll[] $quizInputOptionToResultPolls
 */
class QuizInputOption extends QuizBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_input_option';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['value', 'quiz_input_id'], 'required'],
            [['content', 'interpretation'], 'string'],
            [['score', 'row', 'column', 'quiz_input_id'], 'integer'],
            [['value'], 'string', 'max' => 255],
            [['quiz_input_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizInput::className(), 'targetAttribute' => ['quiz_input_id' => 'id'], 'except' => 'test'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'value' => 'Value',
            'content' => 'Content',
            'score' => 'Score',
            'interpretation' => 'Interpretation',
            'row' => 'Row',
            'column' => 'Column',
            'quiz_input_id' => 'Quiz Input ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizInput()
    {
        return $this->hasOne(QuizInput::className(), ['id' => 'quiz_input_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizInputOptionToResultPolls()
    {
        return $this->hasMany(QuizInputOptionToResultPoll::className(), ['quiz_input_option_id' => 'id']);
    }
}
