<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 4/4/2017
 * Time: 12:14 AM
 */

namespace frontend\models;


use common\models\MyActiveRecord;
use yii\helpers\Url;

class Article extends MyActiveRecord
{
    public function getUrl()
    {
        return Url::to(['article/index', 'slug' => $this->slug], true);
    }
}