<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

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
    <div class="container">
        <div class="img-wrap">
            <img src="<?= Yii::getAlias('@web/img/desktop_logo_banner.png') ?>" alt="<?= Yii::$app->name ?>">
        </div>
    </div>
    <div class="container">
        <?= $this->render('navBar') ?>
    </div>
    <div class="container">
        <?= $this->render('slider') ?>
    </div>
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
    <div class="container">
        <p>&copy; <?= Yii::$app->name ?> <?= date('Y') ?></p>
    </div>
</footer>

<!--<script><?php /*require_once Yii::getAlias('@webroot/js/main.js') */?></script>-->
<?php require_once 'fbMessenger.php' ?>
<?php require_once 'fbSDK.php' ?>
<?php require_once 'tracking.php' ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
