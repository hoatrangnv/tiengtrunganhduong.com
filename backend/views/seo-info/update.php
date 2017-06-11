<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\SeoInfo */

$this->title = 'Update Seo Info: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Seo Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="seo-info-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
