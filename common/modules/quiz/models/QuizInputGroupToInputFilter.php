<?php

namespace common\modules\quiz\models;

use Yii;

/**
 * This is the model class for table "quiz_input_group_to_input_filter".
 *
 * @property integer $id
 * @property integer $input_group_id
 * @property integer $filter_id
 *
 * @property QuizFilter $filter
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
            [['input_group_id', 'filter_id'], 'required'],
            [['input_group_id', 'filter_id'], 'integer'],
            [['filter_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizFilter::className(), 'targetAttribute' => ['filter_id' => 'id']],
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
    public function getInputGroup()
    {
        return $this->hasOne(QuizInputGroup::className(), ['id' => 'input_group_id']);
    }
}
