<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\quiz\searchModels\QuizInputValidator */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="quiz-input-validator-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'arguments') ?>

    <?= $form->field($model, 'quiz_fn_id') ?>

    <?= $form->field($model, 'quiz_id') ?>

    <?php // echo $form->field($model, 'error_message') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
