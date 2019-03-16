<?php


use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use frontend\models\SiteParam;

/**
 * @var $this \yii\web\View
 * @var $content string
 * @var \frontend\models\SeoInfo $seoInfo
 */

AppAsset::register($this);
$seoInfo = $this->context->seoInfo;
$this->title = $seoInfo->name;
$seoInfo->registerMetaTags($this);
$seoInfo->registerLinkTags($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
<title><?= Html::encode($this->title) ?></title>
<meta charset="<?= Yii::$app->charset ?>">
<?php $this->head() ?>
<?php echo Html::csrfMetaTags() ?>
<style><?php /*require_once Yii::getAlias('@webroot/css/main.css') */?></style>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<?php
if (!$seoInfo->disable_ads) {
    ?>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({
            google_ad_client: "ca-pub-5467392149281559",
            enable_page_level_ads: true
        });
    </script>
    <?php
}
?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <div class="container sm-non-padding clr">
        <div class="img-wrap">
            <img src="<?= Yii::getAlias('@web/img/banner.png') ?>" alt="<?= Yii::$app->name ?>">
        </div>
    </div>
    <div class="container sm-non-padding clr">
        <?= $this->render('navBar') ?>
    </div>
    <?php
    if (in_array(Yii::$app->requestedRoute, ['site/index'])) {
        ?>
        <div class="container sm-non-padding clr">
            <?= $this->render('slider') ?>
        </div>
        <?php
    }
    ?>
    <div class="container sm-non-padding clr">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
    </div>
    <div class="container clr">
        <?= Alert::widget() ?>
        <div class="main-content left">
            <?= $content ?>
        </div>
        <aside class="aside right">
            <?php require_once 'aside.php' ?>
        </aside>
    </div>
</div>

<?php require_once 'footer.php' ?>

<?php
if (Yii::$app->response->isSuccessful) {
    require_once 'fbMessenger.php';
    require_once 'fbSDK.php';
    require_once 'googlePlatform.php';
    require_once 'twitterWidget.php';
    require_once 'tracking.php';
}
?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
