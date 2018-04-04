<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "chinese_dictionary".
 *
 * @property integer $id
 * @property string $word
 * @property string $meaning
 */
class ChineseDictionary extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'chinese_dictionary';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['word', 'meaning'], 'required'],
            [['meaning'], 'string'],
            [['word'], 'string', 'max' => 255],
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
            'meaning' => 'Meaning',
        ];
    }
}
