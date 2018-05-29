<?php

use backend\models\MissingWord;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\MissingWord */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="missing-word-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'word')->textInput(['maxlength' => true, 'readonly' => true]) ?>

    <?= $form->field($model, 'search_count')->textInput(['readonly' => true]) ?>

    <?= $form->field($model, 'last_search_time')->textInput(['readonly' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList(MissingWord::$allStatusLabels) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
