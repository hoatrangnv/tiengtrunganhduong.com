<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz_character_medium_to_sorter".
 *
 * @property integer $id
 * @property integer $sorter_order
 * @property integer $character_medium_id
 * @property integer $sorter_id
 *
 * @property QuizCharacterMedium $characterMedium
 * @property QuizSorter $sorter
 */
class QuizCharacterMediumToSorter extends QuizBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_character_medium_to_sorter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sorter_order', 'character_medium_id', 'sorter_id'], 'integer'],
            [['character_medium_id', 'sorter_id'], 'required'],
            [['character_medium_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizCharacterMedium::className(), 'targetAttribute' => ['character_medium_id' => 'id']],
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
            'character_medium_id' => 'Character Medium ID',
            'sorter_id' => 'Sorter ID',
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
    public function getSorter()
    {
        return $this->hasOne(QuizSorter::className(), ['id' => 'sorter_id']);
    }
}
