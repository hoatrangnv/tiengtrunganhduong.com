<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz_input_group_to_input_filter".
 *
 * @property integer $id
 * @property integer $input_group_id
 * @property integer $input_filter_id
 *
 * @property QuizFilter $inputFilter
 * @property QuizInputGroup $inputGroup
 */
class QuizInputGroupToInputFilter extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_input_group_to_input_filter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['input_group_id', 'input_filter_id'], 'required'],
            [['input_group_id', 'input_filter_id'], 'integer'],
            [['input_filter_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizFilter::className(), 'targetAttribute' => ['input_filter_id' => 'id']],
            [['input_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizInputGroup::className(), 'targetAttribute' => ['input_group_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'input_group_id' => 'Input Group ID',
            'input_filter_id' => 'Input Filter ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInputFilter()
    {
        return $this->hasOne(QuizFilter::className(), ['id' => 'input_filter_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInputGroup()
    {
        return $this->hasOne(QuizInputGroup::className(), ['id' => 'input_group_id']);
    }
}
