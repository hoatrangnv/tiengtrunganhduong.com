<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "chinese_phrase_phonetic".
 *
 * @property int $id
 * @property string $phrase
 * @property string $phonetic
 * @property string $vi_phonetic
 * @property string $meaning
 * @property int $type
 */
class ChinesePhrasePhonetic extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'chinese_phrase_phonetic';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['phrase', 'phonetic', 'vi_phonetic'], 'required'],
            [['meaning'], 'string'],
            [['type'], 'integer'],
            [['phrase', 'phonetic', 'vi_phonetic'], 'string', 'max' => 255],
            [['phrase', 'phonetic'], 'unique', 'targetAttribute' => ['phrase', 'phonetic']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'phrase' => 'Phrase',
            'phonetic' => 'Phonetic',
            'vi_phonetic' => 'Vi Phonetic',
            'meaning' => 'Meaning',
            'type' => 'Type',
        ];
    }
}
