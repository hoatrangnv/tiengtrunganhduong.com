<?php


use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use frontend\models\SiteParam;
use yii\helpers\Url;

/**
 * @var $this \yii\web\View
 * @var $content string
 * @var \frontend\models\SeoInfo $seoInfo
 */

//AppAsset::register($this);
$seoInfo = $this->context->seoInfo;
$this->title = $seoInfo->name;
$seoInfo->registerMetaTags($this);
$seoInfo->registerLinkTags($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html amp lang="<?= Yii::$app->language ?>">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <meta charset="<?= Yii::$app->charset ?>">
    <?php $this->head() ?>
    <?= Html::csrfMetaTags() ?>
    <script async src="https://cdn.ampproject.org/v0.js"></script>
    <script type="application/ld+json">
        {
            "@context": "http://schema.org",
            "@type": "NewsArticle",
            "headline": "<?= $seoInfo->name ?>",
            "datePublished": "<?= date('Y-m-dTH:i:sZ', $seoInfo->create_time) ?>",
            "dateModified": "<?= date('Y-m-dTH:i:sZ', $seoInfo->update_time) ?>",
            "image": [
                "<?= ($image_src = $seoInfo->image ? $seoInfo->image->getSource() : '') ? $image_src : Url::home(true) . 'img/default_image.jpg' ?>"
            ],
            "mainEntityOfPage": {
                "@type": "WebPage",
                "@id": "<?= $this->context->canonicalLink ?>"
            },
            "author": {
                "@type": "Organization",
                "name": "<?= Yii::$app->name ?>"
            },
            "publisher": {
                "@type": "Organization",
                "name": "<?= Yii::$app->name ?>",
                "logo": {
                    "@type": "ImageObject",
                    "url": "<?= Url::home(true) ?>img/banner.png",
                    "width": 445,
                    "height": 60
                }
            }
        }
    </script>
    <style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>
    <style amp-custom>
        <?= $this->renderFile(\Yii::getAlias('@webroot/css/amp.min.css'))?>
    </style>

    <!-- More AMP components -->
    <script async custom-element="amp-analytics" src="https://cdn.ampproject.org/v0/amp-analytics-0.1.js"></script>
    <script async custom-element="amp-sidebar" src="https://cdn.ampproject.org/v0/amp-sidebar-0.1.js"></script>
    <?php
    if (isset(Yii::$app->params['has-amp-iframe']) && Yii::$app->params['has-amp-iframe']) {
        ?>
        <script async custom-element="amp-iframe" src="https://cdn.ampproject.org/v0/amp-iframe-0.1.js"></script>
        <?php
    }
    if (isset(Yii::$app->params['has-amp-youtube']) && Yii::$app->params['has-amp-youtube']) {
        ?>
        <script async custom-element="amp-youtube" src="https://cdn.ampproject.org/v0/amp-youtube-0.1.js"></script>
        <?php
    }
    if (isset(Yii::$app->params['has-amp-audio']) && Yii::$app->params['has-amp-audio']) {
        ?>
        <script async custom-element="amp-audio" src="https://cdn.ampproject.org/v0/amp-audio-0.1.js"></script>
        <?php
    }
    if (!$seoInfo->disable_ads) {
        ?>
        <script async custom-element="amp-auto-ads" src="https://cdn.ampproject.org/v0/amp-auto-ads-0.1.js"></script>
        <?php
    }
    ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <?= $this->render('ampSidebar') ?>
    <div class="wrap">
        <div class="container sm-non-padding clr">
            <a class="img-wrap" href="<?= Url::home(true) ?>" title="Về trang chủ">
                <amp-img src="<?= Yii::getAlias('@web/img/banner.png') ?>" width="375" height="50" layout="responsive" alt="<?= Yii::$app->name ?>"></amp-img>
            </a>
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
            <div class="container sm-non-padding clr">
                <?= $this->render('../../layouts/breadcrumb') ?>
            </div>
        </div>
        <?php
        if (!in_array(Yii::$app->requestedRoute, ['site/index'])) {
            ?>
            <div class="container clr">
                <div class="hsk-course-link">
                    <a href="<?= Url::to(['course-registration/index', 'ref' => 'link_below_menu'], true) ?>" title="Đăng ký khóa học Tiếng Trung HSK">
                        <amp-img src="<?= Yii::getAlias('@web/img/hot.gif') ?>" width="22px" height="11px" layout="fixed" alt="hot"></amp-img>
                        <span>Học tiếng Trung giao tiếp &rarr; Đăng ký hôm nay nhận ngay ưu đãi</span>
                    </a>
                </div>
            </div>
            <?php
        }
        ?>
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
    <?php require_once 'tracking.php' ?>
    <?php
    if (!$seoInfo->disable_ads) {
        ?>
        <amp-auto-ads type="adsense" data-ad-client="ca-pub-5467392149281559"></amp-auto-ads>
        <?php
    }
    ?>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

