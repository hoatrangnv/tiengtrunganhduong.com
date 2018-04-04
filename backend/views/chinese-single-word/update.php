<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ChineseSingleWord */

$this->title = 'Update Chinese Single Word: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Chinese Single Words', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="chinese-single-word-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
