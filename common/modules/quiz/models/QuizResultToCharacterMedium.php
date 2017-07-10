<?php

namespace common\modules\quiz\models;

use Yii;

/**
 * This is the model class for table "quiz_result_to_character_medium".
 *
 * @property integer $id
 * @property integer $result_id
 * @property integer $character_medium_id
 *
 * @property QuizCharacterMedium $characterMedium
 * @property QuizResult $result
 * @property QuizResultToCharacterMediumToStyle[] $resultToCharacterMediumToStyles
 */
class QuizResultToCharacterMedium extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_result_to_character_medium';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['result_id', 'character_medium_id'], 'required'],
            [['result_id', 'character_medium_id'], 'integer'],
            [['character_medium_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizCharacterMedium::className(), 'targetAttribute' => ['character_medium_id' => 'id']],
            [['result_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizResult::className(), 'targetAttribute' => ['result_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'result_id' => 'Result ID',
            'character_medium_id' => 'Character Medium ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCharacterMedium()
    {
        return $this->hasOne(QuizCharacterMedium::className(), ['id' => 'character_medium_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResult()
    {
        return $this->hasOne(QuizResult::className(), ['id' => 'result_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResultToCharacterMediumToStyles()
    {
        return $this->hasMany(QuizResultToCharacterMediumToStyle::className(), ['result_to_character_medium_id' => 'id']);
    }
}
