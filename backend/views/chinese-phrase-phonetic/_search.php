<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ChinesePhrasePhoneticSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="chinese-phrase-phonetic-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'type') ?>

    <?= $form->field($model, 'phrase') ?>

    <?= $form->field($model, 'phonetic') ?>

    <?= $form->field($model, 'vi_phonetic') ?>

    <?php // echo $form->field($model, 'meaning') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
