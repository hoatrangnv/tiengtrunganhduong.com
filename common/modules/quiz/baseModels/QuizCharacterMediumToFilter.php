<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz_character_medium_to_filter".
 *
 * @property integer $id
 * @property integer $character_medium_id
 * @property integer $filter_id
 *
 * @property QuizCharacterMedium $characterMedium
 * @property QuizFilter $filter
 */
class QuizCharacterMediumToFilter extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_character_medium_to_filter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['character_medium_id', 'filter_id'], 'required'],
            [['character_medium_id', 'filter_id'], 'integer'],
            [['character_medium_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizCharacterMedium::className(), 'targetAttribute' => ['character_medium_id' => 'id']],
            [['filter_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizFilter::className(), 'targetAttribute' => ['filter_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'character_medium_id' => 'Character Medium ID',
            'filter_id' => 'Filter ID',
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
    public function getFilter()
    {
        return $this->hasOne(QuizFilter::className(), ['id' => 'filter_id']);
    }
}
