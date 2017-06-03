<?php

namespace console\models;

use Yii;

/**
 * This is the model class for table "crawled_page".
 *
 * @property integer $id
 * @property string $url
 * @property string $type
 * @property string $name
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keywords
 * @property string $description
 * @property string $content
 */
class CrawledPage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'crawled_page';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['url'], 'required'],
            [['content'], 'string'],
            [['url', 'name', 'meta_title'], 'string', 'max' => 255],
            [['type'], 'string', 'max' => 32],
            [['meta_description', 'meta_keywords', 'description'], 'string', 'max' => 511],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'Url',
            'type' => 'Type',
            'name' => 'Name',
            'meta_title' => 'Meta Title',
            'meta_description' => 'Meta Description',
            'meta_keywords' => 'Meta Keywords',
            'description' => 'Description',
            'content' => 'Content',
        ];
    }
}
