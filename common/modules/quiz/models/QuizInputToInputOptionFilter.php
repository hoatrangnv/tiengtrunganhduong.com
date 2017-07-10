<?php

namespace common\modules\quiz\models;

use Yii;

/**
 * This is the model class for table "quiz_input_to_input_option_filter".
 *
 * @property integer $id
 * @property integer $input_id
 * @property integer $input_option_filter_id
 *
 * @property QuizInput $input
 * @property QuizFilter $inputOptionFilter
 */
class QuizInputToInputOptionFilter extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_input_to_input_option_filter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['input_id', 'input_option_filter_id'], 'required'],
            [['input_id', 'input_option_filter_id'], 'integer'],
            [['input_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizInput::className(), 'targetAttribute' => ['input_id' => 'id']],
            [['input_option_filter_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizFilter::className(), 'targetAttribute' => ['input_option_filter_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'input_id' => 'Input ID',
            'input_option_filter_id' => 'Input Option Filter ID',
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
    public function getInputOptionFilter()
    {
        return $this->hasOne(QuizFilter::className(), ['id' => 'input_option_filter_id']);
    }
}
