<?php

namespace common\modules\quiz\models;

use Yii;

/**
 * This is the model class for table "quiz_validator".
 *
 * @property integer $id
 * @property string $name
 * @property string $validation
 * @property integer $quiz_id
 *
 * @property QuizInputToValidator[] $inputToValidators
 * @property Quiz $quiz
 */
class QuizValidator extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_validator';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'validation'], 'required'],
            [['validation'], 'string'],
            [['quiz_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['quiz_id'], 'exist', 'skipOnError' => true, 'targetClass' => Quiz::className(), 'targetAttribute' => ['quiz_id' => 'id']],
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
            'validation' => 'Validation',
            'quiz_id' => 'Quiz ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInputToValidators()
    {
        return $this->hasMany(QuizInputToValidator::className(), ['validator_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuiz()
    {
        return $this->hasOne(Quiz::className(), ['id' => 'quiz_id']);
    }
}
