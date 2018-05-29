<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "missing_word".
 *
 * @property integer $id
 * @property string $word
 * @property integer $search_count
 * @property string $last_search_time
 * @property integer $status
 */
class MissingWord extends \yii\db\ActiveRecord
{
    const STATUS_NEW = 1;
    const STATUS_FILLED = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'missing_word';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['word', 'search_count', 'last_search_time', 'status'], 'required'],
            [['search_count', 'status'], 'integer'],
            [['last_search_time'], 'safe'],
            [['word'], 'string', 'max' => 255],
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
            'search_count' => 'Search Count',
            'last_search_time' => 'Last Search Time',
            'status' => 'Status',
        ];
    }
}
