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
 * @property integer $status
 */
class NameTranslation extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;
    const STATUS_PENDING = 3;

    /**
     * @return array
     */
    public static function getStatuses()
    {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_INACTIVE => 'Inactive',
            self::STATUS_PENDING => 'Pending',
        ];
    }

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
            [['word', 'translated_word'], 'required'],
            [['meaning'], 'string'],
            [['status'], 'integer'],
            [['word', 'translated_word', 'spelling'], 'string', 'max' => 255],
            [['word'], 'unique'],
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
            'status' => 'Status',
        ];
    }
}
