<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ChinesePhrasePhonetic */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="chinese-phrase-phonetic-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'phrase')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phonetic')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vi_phonetic')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meaning')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'type')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
