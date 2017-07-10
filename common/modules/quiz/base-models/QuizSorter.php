<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz_sorter".
 *
 * @property integer $id
 * @property string $name
 * @property string $rule
 * @property integer $quiz_id
 *
 * @property QuizCharacterMediumToSorter[] $characterMediumToSorters
 * @property QuizCharacterToSorter[] $characterToSorters
 * @property Quiz $quiz
 */
class QuizSorter extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_sorter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['rule'], 'string'],
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
            'rule' => 'Rule',
            'quiz_id' => 'Quiz ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCharacterMediumToSorters()
    {
        return $this->hasMany(QuizCharacterMediumToSorter::className(), ['sorter_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCharacterToSorters()
    {
        return $this->hasMany(QuizCharacterToSorter::className(), ['sorter_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuiz()
    {
        return $this->hasOne(Quiz::className(), ['id' => 'quiz_id']);
    }
}
