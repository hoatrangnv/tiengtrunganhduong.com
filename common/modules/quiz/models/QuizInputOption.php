<?php

namespace common\modules\quiz\models;

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
 * @property integer $input_id
 *
 * @property QuizInput $input
 * @property QuizInputOptionToResultPoll[] $inputOptionToResultPolls
 */
class QuizInputOption extends \yii\db\ActiveRecord
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
            [['value', 'input_id'], 'required'],
            [['content', 'interpretation'], 'string'],
            [['score', 'row', 'column', 'input_id'], 'integer'],
            [['value'], 'string', 'max' => 255],
            [['input_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizInput::className(), 'targetAttribute' => ['input_id' => 'id']],
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
            'input_id' => 'Input ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInput()
    {
        return $this->hasOne(QuizInput::className(), ['id' => 'input_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInputOptionToResultPolls()
    {
        return $this->hasMany(QuizInputOptionToResultPoll::className(), ['input_option_id' => 'id']);
    }
}
