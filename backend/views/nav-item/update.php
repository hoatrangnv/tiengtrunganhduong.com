<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\NavItem */

$this->title = 'Update Nav Item: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Nav Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="nav-item-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
