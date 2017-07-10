<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz_character_to_sorter".
 *
 * @property integer $id
 * @property integer $sorter_order
 * @property integer $character_id
 * @property integer $sorter_id
 *
 * @property QuizCharacter $character
 * @property QuizSorter $sorter
 */
class QuizCharacterToSorter extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_character_to_sorter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sorter_order', 'character_id', 'sorter_id'], 'integer'],
            [['character_id', 'sorter_id'], 'required'],
            [['character_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizCharacter::className(), 'targetAttribute' => ['character_id' => 'id']],
            [['sorter_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizSorter::className(), 'targetAttribute' => ['sorter_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sorter_order' => 'Sorter Order',
            'character_id' => 'Character ID',
            'sorter_id' => 'Sorter ID',
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
    public function getSorter()
    {
        return $this->hasOne(QuizSorter::className(), ['id' => 'sorter_id']);
    }
}
