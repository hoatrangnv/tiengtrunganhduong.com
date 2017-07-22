<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Crawler */

$this->title = 'Create Crawler';
$this->params['breadcrumbs'][] = ['label' => 'Crawlers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="crawler-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
