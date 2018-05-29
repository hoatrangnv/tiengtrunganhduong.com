<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\MissingWord */

$this->title = 'Create Missing Word';
$this->params['breadcrumbs'][] = ['label' => 'Missing Words', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="missing-word-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
