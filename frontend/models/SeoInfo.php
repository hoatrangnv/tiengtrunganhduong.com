<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 6/17/2017
 * Time: 12:22 AM
 */

namespace frontend\models;

use Yii;

class SeoInfo extends \common\models\SeoInfo
{
    public static function findOneByRequestInfo()
    {
        $host = Yii::$app->request->hostInfo;
        $url_path = parse_url(Yii::$app->request->absoluteUrl, PHP_URL_PATH);
        $model = self::find()
            ->where(['REGEXP', 'url', "$url_path"])
            ->oneActive();
        return $model;
    }

}