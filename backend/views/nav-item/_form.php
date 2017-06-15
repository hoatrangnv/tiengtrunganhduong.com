<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\NavItem;

/* @var $this yii\web\View */
/* @var $model backend\models\NavItem */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="nav-item-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'parent_id')->dropDownList(
        NavItem::dropDownListData(),
        ['prompt' => Yii::t('app', 'Select one ...')]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'target_model_type')->dropDownList(
        NavItem::getTargetModelTypes(),
        ['prompt' => Yii::t('app', 'Select one ...')]
    ) ?>

    <?= $form->field($model, 'target_model_id')->textInput() ?>

    <?= $form->field($model, 'active')->checkbox() ?>

    <?php// $form->field($model, 'type')->textInput() ?>

    <?= $form->field($model, 'sort_order')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
