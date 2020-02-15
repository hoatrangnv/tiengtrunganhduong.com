<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\ChinesePhrasePhonetic */

$this->title = 'Create Chinese Phrase Phonetic';
$this->params['breadcrumbs'][] = ['label' => 'Chinese Phrase Phonetics', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="chinese-phrase-phonetic-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
