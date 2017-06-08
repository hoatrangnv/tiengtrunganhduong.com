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
<style>
    <?php
//    require_once Yii::getAlias('@webroot/css/main.css');
    ?>
</style>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <div class="container">
        <?= $this->render('navigation') ?>
    </div>
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="wrap">
    <div class="container">
        <p>&copy; <?= Yii::$app->name ?> <?= date('Y') ?></p>
    </div>
</footer>

<script>
    <?php
//    require_once Yii::getAlias('@webroot/js/main.js')
    ?>
</script>
<?php //!in_array(Yii::$app->requestedRoute, ['article/view']) ? : require_once 'disqus.php' ?>
<?php require_once 'tracking.php' ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
