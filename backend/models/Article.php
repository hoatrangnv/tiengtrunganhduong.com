<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 3/31/2017
 * Time: 12:30 AM
 */

namespace backend\models;

use yii\helpers\Url;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * Class Article
 * @package backend\models
 *
 * @property User $creator
 * @property User $updater
 * @property Image $image
 * @property ArticleCategory $category
 *
 */

class Article extends \common\models\Article
{
    public function getUrl($params = [])
    {
        // TODO: Implement getUrl() method.
        return Url::to(array_merge(['article/update', 'id' => $this->id], $params), true);
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

    public function rules()
    {
        return array_merge(parent::rules(), [
            ['publish_time_timestamp', 'date', 'format' => 'php:' . self::TIMESTAMP_FORMAT],
        ]);
    }
}