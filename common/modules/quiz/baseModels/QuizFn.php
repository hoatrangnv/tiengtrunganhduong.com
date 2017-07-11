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
 * @property QuizFilter[] $quizFilters
 * @property QuizParam[] $quizParams
 * @property QuizSorter[] $quizSorters
 * @property QuizValidator[] $quizValidators
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
    public function getQuizFilters()
    {
        return $this->hasMany(QuizFilter::className(), ['condition_fn_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizParams()
    {
        return $this->hasMany(QuizParam::className(), ['value_fn_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizSorters()
    {
        return $this->hasMany(QuizSorter::className(), ['rule_fn_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizValidators()
    {
        return $this->hasMany(QuizValidator::className(), ['validation_fn_id' => 'id']);
    }
}
