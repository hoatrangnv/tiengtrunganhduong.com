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

class Article extends CommonArticle
{
    public function getUrl($params = [])
    {
        return Url::to(array_merge(['article/view', UrlParam::SLUG => $this->slug], $params), true);
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
        if ($model = Article::find()->where(['slug' => $slug])->onePublished()) {
            return $model;
        }
        return null;
    }
}