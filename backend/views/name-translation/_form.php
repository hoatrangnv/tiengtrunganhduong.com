<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\NameTranslation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="name-translation-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'word')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'translated_word')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'spelling')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meaning')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->dropDownList(\backend\models\NameTranslation::getStatuses()) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
