<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use common\behaviors\MySluggableBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
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
 * @property integer $hot
 * @property integer $status
 * @property integer $type
 * @property integer $sort_order
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $publish_time
 * @property integer $views
 * @property integer $likes
 * @property integer $comments
 * @property integer $shares
 *
 * @property Image $image
 * @property User $creator
 * @property User $updater
 */
abstract class Article extends \common\models\MyActiveRecord
{
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
            [
                'class' => MySluggableBehavior::className(),
                'attribute' => 'name',
                'slugAttribute' => 'slug',
                'immutable' => false,
                'ensureUnique' => true,
            ],
        ];
    }

    public $publish_time_timestamp;

    public function __construct(array $config = [])
    {
        // Init publish time for new record, round up ten minute (600s)
        if ($this->isNewRecord) {
            $this->publish_time_timestamp = date('Y-m-d H:i:s', 600 * ceil(time() / 600));
        }
        parent::__construct($config);
    }

    public function afterFind()
    {
        // Init publish time for record found
        $this->publish_time_timestamp = date('Y-m-d H:i:s', $this->publish_time);
        parent::afterFind();
    }

    public function beforeSave($insert)
    {
        //
        $this->publish_time = strtotime($this->publish_time_timestamp);
        return parent::beforeSave($insert);
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
            [[/*'creator_id', 'updater_id',*/ 'category_id', 'image_id', 'active', 'visible', 'hot', 'status', 'type', 'sort_order', /*'create_time', 'update_time',*/ 'publish_time', 'views', 'likes', 'comments', 'shares'], 'integer'],
            [[/*'slug', */'name', 'content'], 'required'],
            [['content', 'sub_content'], 'string'],
            [[/*'slug', */'name', 'meta_title'], 'string', 'max' => 128],
            [['meta_keywords', 'meta_description', 'description'], 'string', 'max' => 512],
//            [['slug'], 'unique'],
            [['image_id'], 'exist', 'skipOnError' => true, 'targetClass' => Image::className(), 'targetAttribute' => ['image_id' => 'id']],
//            [['creator_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creator_id' => 'id']],
//            [['updater_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updater_id' => 'id']],
            ['publish_time_timestamp', 'date', 'format' => 'php:Y-m-d H:i:s'],
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
            'hot' => 'Hot',
            'status' => 'Status',
            'type' => 'Type',
            'sort_order' => 'Sort Order',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'publish_time' => 'Publish Time',
            'views' => 'Views',
            'likes' => 'Likes',
            'comments' => 'Comments',
            'shares' => 'Shares',
        ];
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
}
