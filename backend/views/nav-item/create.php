<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\NavItem */

$this->title = 'Create Nav Item';
$this->params['breadcrumbs'][] = ['label' => 'Nav Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nav-item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
