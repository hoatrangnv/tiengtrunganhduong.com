<?php

namespace common\modules\quiz\models;

use Yii;

/**
 * This is the model class for table "quiz_character_medium".
 *
 * @property integer $id
 * @property string $name
 * @property string $var_name
 * @property string $type
 * @property integer $index
 * @property integer $global_exec_order
 * @property integer $quiz_id
 * @property integer $character_id
 *
 * @property QuizCharacter $character
 * @property Quiz $quiz
 * @property QuizCharacterMediumToFilter[] $characterMediumToFilters
 * @property QuizCharacterMediumToSorter[] $characterMediumToSorters
 * @property QuizCharacterMediumToStyle[] $characterMediumToStyles
 * @property QuizResultToCharacterMedium[] $resultToCharacterMedia
 */
class QuizCharacterMedium extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_character_medium';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'var_name', 'type', 'index', 'global_exec_order', 'character_id'], 'required'],
            [['index', 'global_exec_order', 'quiz_id', 'character_id'], 'integer'],
            [['name', 'var_name', 'type'], 'string', 'max' => 255],
            [['character_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizCharacter::className(), 'targetAttribute' => ['character_id' => 'id']],
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
            'character_id' => 'Character ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCharacter()
    {
        return $this->hasOne(QuizCharacter::className(), ['id' => 'character_id']);
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
    public function getCharacterMediumToFilters()
    {
        return $this->hasMany(QuizCharacterMediumToFilter::className(), ['character_medium_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCharacterMediumToSorters()
    {
        return $this->hasMany(QuizCharacterMediumToSorter::className(), ['character_medium_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCharacterMediumToStyles()
    {
        return $this->hasMany(QuizCharacterMediumToStyle::className(), ['character_medium_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResultToCharacterMedia()
    {
        return $this->hasMany(QuizResultToCharacterMedium::className(), ['character_medium_id' => 'id']);
    }
}
