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
 *
 * @property User $creator
 * @property User $updater
 * @property Image $image
 * @property ArticleCategory $category
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

    public $publish_time_timestamp;

    const TIMESTAMP_FORMAT = 'Y-m-d H:i:s';

    public function __construct(array $config = [])
    {
        // Init publish time for new record
        if ($this->isNewRecord) {
            $this->publish_time_timestamp = date(self::TIMESTAMP_FORMAT, $this->getDefaultPublishTime());
        }
        parent::__construct($config);
    }

    public function afterFind()
    {
        // Init publish time for record found
        $this->publish_time_timestamp = date(self::TIMESTAMP_FORMAT, $this->publish_time);
        parent::afterFind();
    }

    public function beforeSave($insert)
    {
        if (!$this->publish_time_timestamp) {
            $this->publish_time = $this->getDefaultPublishTime();
            $this->publish_time_timestamp = date(self::TIMESTAMP_FORMAT, $this->publish_time);
        } else {
            $this->publish_time = strtotime($this->publish_time_timestamp);
        }
        return parent::beforeSave($insert);
    }

    public function getDefaultPublishTime()
    {
        // Round up ten minute (600s)
        return 600 * ceil(time() / 600);
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
            [[/*'creator_id', 'updater_id',*/ 'category_id', 'image_id', 'active', 'visible', 'featured',
                'status', 'type', 'sort_order', /*'create_time', 'update_time',*/
                'publish_time', 'view_count', 'like_count', 'comment_count', 'share_count'], 'integer'],
            [['slug', 'name', 'content'], 'required'],
            [['content', 'sub_content'], 'string'],
            [['slug', 'name', 'meta_title'], 'string', 'max' => 255],
            [['meta_keywords', 'meta_description', 'description'], 'string', 'max' => 511],
            [['slug'], 'unique'],
            [['image_id'], 'exist', 'skipOnError' => true, 'targetClass' => Image::className(), 'targetAttribute' => ['image_id' => 'id']],
//            [['creator_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creator_id' => 'id']],
//            [['updater_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updater_id' => 'id']],
            ['publish_time_timestamp', 'date', 'format' => 'php:' . self::TIMESTAMP_FORMAT],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreator()
    {
        return $this->hasOne(User::className(), ['id' => 'creator_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdater()
    {
        return $this->hasOne(User::className(), ['id' => 'updater_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'image_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(ArticleCategory::className(), ['id' => 'category_id']);
    }

    /**
     * Query Template
     */

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
