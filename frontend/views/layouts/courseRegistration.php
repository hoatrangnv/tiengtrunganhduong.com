<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 3/16/2019
 * Time: 10:23 AM
 */

/**
 * @var $this \yii\web\View
 * @var $content string
 * @var \frontend\models\SeoInfo $seoInfo
 */

$this->beginPage();
$this->head();
$this->beginBody();
echo $content;
if (Yii::$app->response->isSuccessful) {
    require_once 'fbSDK.php';
    require_once 'tracking.php';
}
$this->endBody();
$this->endPage();