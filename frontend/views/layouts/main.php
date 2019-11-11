<?php


use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;
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
<html lang="<?= Yii::$app->language ?>" itemscope itemtype="https://schema.org/WebSite">
<head>
<title><?= Html::encode($this->title) ?></title>
<meta charset="<?= Yii::$app->charset ?>">
<?php $this->head() ?>
<?php echo Html::csrfMetaTags() ?>
<?php
if (!$seoInfo->disable_ads) {
?>
    <script data-ad-client="ca-pub-5467392149281559" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
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
        <?= $this->render('//layouts/breadcrumb') ?>
    </div>
    <?php
    if (!in_array(Yii::$app->requestedRoute, ['site/index'])) {
        ?>
        <div class="container clr">
            <div class="hsk-course-link">
                <a href="<?= Url::to(['course-registration/index', 'ref' => 'link_below_menu'], true) ?>" title="Đăng ký khóa học Tiếng Trung HSK">
                    <img src="<?= Yii::getAlias('@web/img/hot.gif') ?>"/>
                    <span>Học tiếng Trung giao tiếp &rarr; Đăng ký hôm nay nhận ngay ưu đãi</span>
                </a>
            </div>
        </div>
        <?php
    }
    ?>
    <div class="container clr">
        <?= Alert::widget() ?>
        <div class="main-content left" itemprop="mainEntityOfPage">
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
