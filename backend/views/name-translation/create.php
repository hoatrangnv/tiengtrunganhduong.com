<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\NameTranslation */

$this->title = 'Create Name Translation';
$this->params['breadcrumbs'][] = ['label' => 'Name Translations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="name-translation-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
