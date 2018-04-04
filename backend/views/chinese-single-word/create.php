<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\ChineseSingleWord */

$this->title = 'Create Chinese Single Word';
$this->params['breadcrumbs'][] = ['label' => 'Chinese Single Words', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="chinese-single-word-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
