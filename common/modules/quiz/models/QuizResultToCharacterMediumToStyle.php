<?php

namespace common\modules\quiz\models;

use Yii;

/**
 * This is the model class for table "quiz_result_to_character_medium_to_style".
 *
 * @property integer $id
 * @property integer $style_order
 * @property integer $result_to_character_medium_id
 * @property integer $style_id
 *
 * @property QuizStyle $style
 * @property QuizResultToCharacterMedium $resultToCharacterMedium
 */
class QuizResultToCharacterMediumToStyle extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_result_to_character_medium_to_style';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['style_order', 'result_to_character_medium_id', 'style_id'], 'integer'],
            [['result_to_character_medium_id', 'style_id'], 'required'],
            [['style_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizStyle::className(), 'targetAttribute' => ['style_id' => 'id']],
            [['result_to_character_medium_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizResultToCharacterMedium::className(), 'targetAttribute' => ['result_to_character_medium_id' => 'id']],
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
            'result_to_character_medium_id' => 'Result To Character Medium ID',
            'style_id' => 'Style ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStyle()
    {
        return $this->hasOne(QuizStyle::className(), ['id' => 'style_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResultToCharacterMedium()
    {
        return $this->hasOne(QuizResultToCharacterMedium::className(), ['id' => 'result_to_character_medium_id']);
    }
}
