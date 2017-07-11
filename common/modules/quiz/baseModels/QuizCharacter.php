<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz_character".
 *
 * @property integer $id
 * @property string $name
 * @property string $var_name
 * @property string $type
 * @property integer $index
 * @property integer $global_exec_order
 * @property integer $quiz_id
 *
 * @property Quiz $quiz
 * @property QuizCharacterMedium[] $characterMedia
 * @property QuizCharacterToFilter[] $characterToFilters
 * @property QuizCharacterToSorter[] $characterToSorters
 */
class QuizCharacter extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_character';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'var_name', 'type', 'index', 'global_exec_order'], 'required'],
            [['index', 'global_exec_order', 'quiz_id'], 'integer'],
            [['name', 'var_name', 'type'], 'string', 'max' => 255],
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
            'var_name' => 'Var Name',
            'type' => 'Type',
            'index' => 'Index',
            'global_exec_order' => 'Global Exec Order',
            'quiz_id' => 'Quiz ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuiz()
    {
        return $this->hasOne(Quiz::className(), ['id' => 'quiz_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCharacterMedia()
    {
        return $this->hasMany(QuizCharacterMedium::className(), ['character_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCharacterToFilters()
    {
        return $this->hasMany(QuizCharacterToFilter::className(), ['character_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCharacterToSorters()
    {
        return $this->hasMany(QuizCharacterToSorter::className(), ['character_id' => 'id']);
    }
}
