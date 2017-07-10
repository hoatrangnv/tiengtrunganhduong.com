<?php

namespace common\modules\quiz\models;

use Yii;

/**
 * This is the model class for table "quiz_input_to_input_option_filter".
 *
 * @property integer $id
 * @property integer $input_id
 * @property integer $filter_id
 *
 * @property QuizFilter $filter
 * @property QuizInput $input
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
            [['input_id', 'filter_id'], 'required'],
            [['input_id', 'filter_id'], 'integer'],
            [['filter_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizFilter::className(), 'targetAttribute' => ['filter_id' => 'id']],
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
            'input_id' => 'Input ID',
            'filter_id' => 'Filter ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFilter()
    {
        return $this->hasOne(QuizFilter::className(), ['id' => 'filter_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInput()
    {
        return $this->hasOne(QuizInput::className(), ['id' => 'input_id']);
    }
}
