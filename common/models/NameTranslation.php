<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "name_translation".
 *
 * @property integer $id
 * @property string $word
 * @property string $translated_word
 * @property string $spelling
 * @property string $meaning
 * @property integer $type
 */
class NameTranslation extends \yii\db\ActiveRecord
{
    const TYPE_FIRST_NAME = 1;
    const TYPE_LAST_NAME = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'name_translation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['word', 'translated_word', 'spelling'], 'required'],
            [['meaning'], 'string'],
            [['type'], 'integer'],
            [['word', 'translated_word', 'spelling'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'word' => 'Word',
            'translated_word' => 'Translated Word',
            'spelling' => 'Spelling',
            'meaning' => 'Meaning',
            'type' => 'Type',
        ];
    }
}
