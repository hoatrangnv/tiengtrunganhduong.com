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
        "headline": "<?= $seoInfo->meta_title ?>",
        "datePublished": "<?= date('Y-m-dTH:i:sZ', $seoInfo->create_time) ?>",
        "image": [
          "<?= $seoInfo->image ? $seoInfo->image->getSource() : '' ?>"
        ]
      }
    </script>
    <style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>
</head>
<body>
    <?php $this->beginBody() ?>
    <div class="wrap">
        <div class="container sm-non-padding clr">
            <div class="img-wrap">
                <amp-img src="<?= Yii::getAlias('@web/img/desktop_logo_banner.png') ?>" width="375" height="50" layout="responsive" alt="<?= Yii::$app->name ?>"></amp-img>
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
    <?php //require_once 'tracking.php' ?>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
