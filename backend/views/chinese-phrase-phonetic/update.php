<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ChinesePhrasePhonetic */

$this->title = 'Update Chinese Phrase Phonetic: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Chinese Phrase Phonetics', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="chinese-phrase-phonetic-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
