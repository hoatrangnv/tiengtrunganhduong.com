<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\SluggableBehavior;
use common\behaviors\MySluggableBehavior;
use yii\validators\DateValidator;

/**
 * This is the model class for table "article".
 *
 * @property integer $id
 * @property integer $creator_id
 * @property integer $updater_id
 * @property integer $category_id
 * @property integer $image_id
 * @property string $slug
 * @property string $name
 * @property string $meta_title
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $description
 * @property string $content
 * @property string $sub_content
 * @property integer $active
 * @property integer $visible
 * @property integer $featured
 * @property integer $shown_on_menu
 * @property integer $type
 * @property integer $status
 * @property integer $sort_order
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $publish_time
 * @property integer $view_count
 * @property integer $like_count
 * @property integer $comment_count
 * @property integer $share_count
 * @property integer $doindex
 * @property integer $dofollow
 * @property string $menu_label
 *
 */
class Article extends \common\models\MyActiveRecord
{
    public function getUrl($params = [])
    {
        // TODO: Implement getUrl() method.
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[/*'creator_id', 'updater_id',*/ 'category_id', 'image_id',
                'active', 'visible', 'featured', 'shown_on_menu',
                'status', 'type', 'sort_order', /*'create_time', 'update_time',*/
                'publish_time', 'view_count', 'like_count', 'comment_count', 'share_count',
                'doindex', 'dofollow',], 'integer'],
            [['slug', 'name', 'content'], 'required'],
            [['content', 'sub_content'], 'string'],
            [['slug', 'name', 'meta_title', 'menu_label'], 'string', 'max' => 255],
            [['meta_keywords', 'meta_description', 'description'], 'string', 'max' => 511],
            [['slug'], 'unique'],
            [['image_id'], 'exist', 'skipOnError' => true, 'targetClass' => Image::className(), 'targetAttribute' => ['image_id' => 'id']],
//            [['creator_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creator_id' => 'id']],
//            [['updater_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updater_id' => 'id']],
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
            'category_id' => 'Category ID',
            'image_id' => 'Image ID',
            'slug' => 'Slug',
            'name' => 'Name',
            'meta_title' => 'Meta Title',
            'meta_keywords' => 'Meta Keywords',
            'meta_description' => 'Meta Description',
            'description' => 'Description',
            'content' => 'Content',
            'sub_content' => 'Sub Content',
            'active' => 'Active',
            'visible' => 'Visible',
            'featured' => 'Featured',
            'shown_on_menu' => 'Shown On Menu',
            'status' => 'Status',
            'type' => 'Type',
            'sort_order' => 'Sort Order',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'publish_time' => 'Publish Time',
            'view_count' => 'View Count',
            'like_count' => 'Like Count',
            'comment_count' => 'Comment Count',
            'share_count' => 'Share Count',
            'doindex' => 'Doindex',
            'dofollow' => 'Dofollow',
            'menu_label' => 'Menu Label',
        ];
    }

    /** Query Template */

    /**
     * @return array
     */
    public function templateMethods()
    {
        return [
            'attribute' => function ($name) {
                return $this->getAttribute($name);
            },
            'aTag' => function ($text = null, $options = []) {
                return $this->a($text, $options);
            },
            'image' => function () {
                return $this->getImage()->oneActive();
            },
        ];
    }
}
