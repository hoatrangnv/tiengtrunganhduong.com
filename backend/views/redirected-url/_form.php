<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\RedirectedUrl */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="redirected-url-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'type')->dropDownList(\backend\models\RedirectedUrl::getTypes()) ?>

    <?= $form->field($model, 'from_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'to_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'active')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
