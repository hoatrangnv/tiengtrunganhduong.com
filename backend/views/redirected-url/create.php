<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\RedirectedUrl */

$this->title = 'Create Redirected Url';
$this->params['breadcrumbs'][] = ['label' => 'Redirected Urls', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="redirected-url-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
