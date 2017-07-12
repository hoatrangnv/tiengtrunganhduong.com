<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz_fn".
 *
 * @property integer $id
 * @property string $name
 * @property string $parameters
 * @property string $body
 *
 * @property QuizFilter[] $filters
 * @property QuizParam[] $params
 * @property QuizSorter[] $sorters
 * @property QuizValidator[] $validators
 */
class QuizFn extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_fn';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'parameters', 'body'], 'required'],
            [['body'], 'string'],
            [['name', 'parameters'], 'string', 'max' => 255],
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
            'parameters' => 'Parameters',
            'body' => 'Body',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFilters()
    {
        return $this->hasMany(QuizFilter::className(), ['condition_fn_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParams()
    {
        return $this->hasMany(QuizParam::className(), ['value_fn_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSorters()
    {
        return $this->hasMany(QuizSorter::className(), ['rule_fn_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValidators()
    {
        return $this->hasMany(QuizValidator::className(), ['validation_fn_id' => 'id']);
    }
}
