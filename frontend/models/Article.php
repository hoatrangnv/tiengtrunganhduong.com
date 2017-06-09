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

    public static function findOneBySlug($slug)
    {
        if ($model = Article::find()->where(['slug' => $slug])->onePublished()) {
            return $model;
        }
        return null;
    }
}