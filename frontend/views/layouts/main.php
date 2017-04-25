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
$this->registerMetaTag([
    'name' => 'propeller',
    'content' => 'f3aac67abe9ca2b997e4162b0c9d7661'
]);
//propeller_popunder
//$this->registerJsFile('//go.onclasrv.com/apu.php?zoneid=1177264');
//propeller_dialog
//$this->registerJsFile('//go.mobisla.com/notice.php?p=1177286&interactive=1&pushup=1', ['async' => 'async']);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
<meta charset="<?= Yii::$app->charset ?>">
<?php $this->head() ?>
<?= Html::csrfMetaTags() ?>
<title><?= Html::encode($this->title) ?></title>
<style><?php require_once Yii::getAlias('@webroot/css/main.css') ?></style>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
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
        <p class="pull-left">&copy; <?= Yii::$app->name ?> <?= date('Y') ?></p>
    </div>
</footer>

<script><?php require_once Yii::getAlias('@webroot/js/main.js') ?></script>
<?php require_once 'tracking.php' ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
