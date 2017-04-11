<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 3/31/2017
 * Time: 12:30 AM
 */

namespace backend\models;

use yii\helpers\Url;

class Article extends \common\models\Article
{
    public function getUrl($params = [])
    {
        // TODO: Implement getUrl() method.
        return Url::to(array_merge(['article/update', 'id' => $this->id], $params), true);
    }
}