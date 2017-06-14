<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use frontend\models\SiteParam;

AppAsset::register($this);
$this->registerMetaTag([
    'name' => 'viewport',
    'content' => 'width=device-width, initial-scale=1'
]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
<meta charset="<?= Yii::$app->charset ?>">
<?php $this->head() ?>
<?= Html::csrfMetaTags() ?>
<title><?= Html::encode($this->title) ?></title>
<!--<style><?php /*require_once Yii::getAlias('@webroot/css/main.css') */?></style>-->
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <div class="container clr">
        <div class="img-wrap">
            <img src="<?= Yii::getAlias('@web/img/desktop_logo_banner.png') ?>" alt="<?= Yii::$app->name ?>">
        </div>
    </div>
    <div class="container clr">
        <?= $this->render('navBar') ?>
    </div>
    <?php
    if (in_array(Yii::$app->requestedRoute, ['site/index'])) {
        ?>
        <div class="container clr">
            <?= $this->render('slider') ?>
        </div>
        <?php
    }
    ?>
    <div class="container clr">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <div class="main-content left">
            <?= $content ?>
        </div>
        <aside class="aside right">
            <?php require_once 'aside.php' ?>
        </aside>
    </div>
</div>

<footer class="wrap">
    <div class="container clr">
        <div>
            <h3><?= ($item = SiteParam::findOneByName(SiteParam::COMPANY_NAME)) ? $item->value : '' ?></h3>
        </div>
        <div>
            <div><?= Yii::t('app', 'Address') ?>: <?= ($item = SiteParam::findOneByName(SiteParam::ADDRESS)) ? $item->value : '' ?></div>
            <div>Email: <?= ($item = SiteParam::findOneByName(SiteParam::EMAIL)) ? $item->value : '' ?></div>
            <div>Hotline: <?= ($item = SiteParam::findOneByName(SiteParam::PHONE_NUMBER)) ? $item->value : '' ?></div>
        </div>
        <div class="social-networks">
            <a title="facebook" href="<?= ($item = SiteParam::findOneByName(SiteParam::FACEBOOK_URL)) ? $item->value : 'javascript:void(0)' ?>" target="_blank" rel="nofollow"><i class="icon facebook-icon"></i></a>
            <a title="twitter" href="<?= ($item = SiteParam::findOneByName(SiteParam::TWITTER_URL)) ? $item->value : 'javascript:void(0)' ?>" target="_blank" rel="nofollow"><i class="icon twitter-icon" ></i></a>
            <a title="google plus" href="<?= ($item = SiteParam::findOneByName(SiteParam::GOOGLE_PLUS_URL)) ? $item->value : 'javascript:void(0)' ?>" target="_blank" rel="nofollow"><i class="icon google-plus-icon"></i></a>
            <a title="youtube" href="<?= ($item = SiteParam::findOneByName(SiteParam::YOUTUBE_URL)) ? $item->value : 'javascript:void(0)' ?>" target="_blank" rel="nofollow"><i class="icon youtube-icon"></i></a>
        </div>
    </div>
</footer>

<!--<script><?php /*require_once Yii::getAlias('@webroot/js/main.js') */?></script>-->
<?php require_once 'fbMessenger.php' ?>
<?php require_once 'fbSDK.php' ?>
<?php require_once 'googlePlatform.php' ?>
<?php require_once 'twitterWidget.php' ?>
<?php require_once 'tracking.php' ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
