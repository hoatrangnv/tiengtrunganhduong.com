<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Contact */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contact-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'readonly' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'readonly' => true]) ?>

    <?= $form->field($model, 'phone_number')->textInput(['maxlength' => true, 'readonly' => true]) ?>

    <?= $form->field($model, 'subject')->textInput(['maxlength' => true, 'readonly' => true]) ?>

    <?= $form->field($model, 'body')->textarea(['rows' => 6, 'readonly' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList(
        \backend\models\Contact::getStatuses(),
        ['prompt' => Yii::t('app', 'Select one ...')]
    ) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
