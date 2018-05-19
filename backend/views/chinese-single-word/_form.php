<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ChineseSingleWord */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="chinese-single-word-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'word')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'spelling')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'spelling_vi')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meaning')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
