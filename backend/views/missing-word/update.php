<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\MissingWord */

$this->title = 'Update Missing Word: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Missing Words', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="missing-word-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
