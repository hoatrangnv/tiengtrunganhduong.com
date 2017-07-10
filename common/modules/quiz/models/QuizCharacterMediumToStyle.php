<?php

namespace common\modules\quiz\models;

use Yii;

/**
 * This is the model class for table "quiz_character_medium_to_style".
 *
 * @property integer $id
 * @property integer $style_order
 * @property integer $character_medium_id
 * @property integer $style_id
 *
 * @property QuizCharacterMedium $characterMedium
 * @property QuizStyle $style
 */
class QuizCharacterMediumToStyle extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_character_medium_to_style';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['style_order', 'character_medium_id', 'style_id'], 'integer'],
            [['character_medium_id', 'style_id'], 'required'],
            [['character_medium_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizCharacterMedium::className(), 'targetAttribute' => ['character_medium_id' => 'id']],
            [['style_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizStyle::className(), 'targetAttribute' => ['style_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'style_order' => 'Style Order',
            'character_medium_id' => 'Character Medium ID',
            'style_id' => 'Style ID',
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
    public function getStyle()
    {
        return $this->hasOne(QuizStyle::className(), ['id' => 'style_id']);
    }
}
