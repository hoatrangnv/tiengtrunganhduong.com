<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 4/4/2017
 * Time: 12:14 AM
 */

namespace frontend\models;

use common\models\Article as CommonArticle;
use common\models\UrlParam;
use yii\helpers\Url;
use Yii;
use Lullabot\AMP\AMP;

/**
 * Class Article
 * @package frontend\models
 *
 * @property User $creator
 * @property User $updater
 * @property Image $image
 * @property ArticleCategory $category
 */

class Article extends CommonArticle
{
    public function getUrl($params = [])
    {
        if (Yii::$app->params['amp']) {
            $params[UrlParam::AMP] = 'amp';
        }
        return Url::to(array_merge(['article/view', UrlParam::SLUG => $this->slug], $params), true);
    }

    public function img($size = null, array $options = [], array $srcOptions = [])
    {
        if (Yii::$app->params['amp']) {
            if (!isset($options['width'])) {
                $options['width'] = 300;
            }
            if (!isset($options['height'])) {
                $options['height'] = 200;
            }
            $options['layout'] = 'responsive';
        }
        $tag = parent::img($size, $options, $srcOptions);
        if (Yii::$app->params['amp']) {
            $tag = str_replace('<img', '<amp-img', $tag);
        }
        return $tag;
    }

    /**
     * @return string
     */
    public function getAmpContent() {
        $cacheKey = __METHOD__ . "@$this->id";
        $cache = Yii::$app->cache->get($cacheKey);
        if ($cache == false || Yii::$app->params["enableCache"] == false) {
            $amp = new AMP;
            $amp->loadHtml($this->content, ['img_max_fixed_layout_width' => 320]);
            $result = $amp->convertToAmpHtml();
            Yii::$app->cache->set($cacheKey, $result, Yii::$app->params['cacheDuration']);
        } else {
            $result = $cache;
        }
        return $result;
    }

    public function desc()
    {
        return $this->description;
    }

    public function date()
    {
        return date('d/m/Y H:i', $this->publish_time);
    }

    public function views()
    {
        return $this->view_count ? $this->view_count : 0;
    }

    public function comments()
    {
        return $this->comment_count ? $this->comment_count : 0;
    }

    public static function findOneBySlug($slug)
    {
        if ($model = Article::find()->where(['slug' => $slug])->oneActive()) {
            return $model;
        }
        return null;
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
}