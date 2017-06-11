<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\SeoInfo */

$this->title = 'Create Seo Info';
$this->params['breadcrumbs'][] = ['label' => 'Seo Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seo-info-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
