<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\SluggableBehavior;
use common\behaviors\MySluggableBehavior;

/**
 * This is the model class for table "article_category".
 *
 * @property integer $id
 * @property integer $creator_id
 * @property integer $updater_id
 * @property integer $image_id
 * @property integer $parent_id
 * @property string $slug
 * @property string $name
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keywords
 * @property string $description
 * @property string $long_description
 * @property integer $active
 * @property integer $visible
 * @property integer $featured
 * @property integer $type
 * @property integer $status
 * @property integer $sort_order
 * @property integer $create_time
 * @property integer $update_time
 *
 */
class ArticleCategory extends \common\models\MyActiveRecord
{
    public function getUrl($params = [])
    {
        // TODO: Implement getUrl() method.
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'creator_id',
                'updatedByAttribute' => 'updater_id',
            ],
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'create_time',
                'updatedAtAttribute' => 'update_time',
                'value' => time(),
            ],
//            [
//                'class' => MySluggableBehavior::className(),
//                'attribute' => 'name',
//                'slugAttribute' => 'slug',
//                'immutable' => false,
//                'ensureUnique' => true,
//            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[/*'creator_id', 'updater_id',*/ 'image_id', 'parent_id', 'active', 'visible', 'featured',
                'type', 'status', 'sort_order', /*'create_time', 'update_time'*/], 'integer'],
            [['slug', 'name'], 'required'],
            [['long_description'], 'string'],
            [['slug', 'name', 'meta_title'], 'string', 'max' => 255],
            [['meta_description', 'meta_keywords', 'description'], 'string', 'max' => 511],
            [['slug'], 'unique'],
//            [['creator_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creator_id' => 'id']],
//            [['updater_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updater_id' => 'id']],
            [['image_id'], 'exist', 'skipOnError' => true, 'targetClass' => Image::className(), 'targetAttribute' => ['image_id' => 'id']],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => ArticleCategory::className(), 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'creator_id' => 'Creator ID',
            'updater_id' => 'Updater ID',
            'image_id' => 'Image ID',
            'parent_id' => 'Parent ID',
            'slug' => 'Slug',
            'name' => 'Name',
            'meta_title' => 'Meta Title',
            'meta_description' => 'Meta Description',
            'meta_keywords' => 'Meta Keywords',
            'description' => 'Description',
            'long_description' => 'Long Description',
            'active' => 'Active',
            'visible' => 'Visible',
            'featured' => 'Featured',
            'type' => 'Type',
            'status' => 'Status',
            'sort_order' => 'Sort Order',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'parent.name' => 'Parent Name',
        ];
    }

}
