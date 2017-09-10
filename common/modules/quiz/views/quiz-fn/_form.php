<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \common\modules\quiz\models\QuizFn;

/* @var $this yii\web\View */
/* @var $model common\modules\quiz\models\QuizFn */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="quiz-fn-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'parameters')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'body')->textarea(['rows' => 12]) ?>

    <?= $form->field($model, 'return_type')->dropDownList(QuizFn::returnTypes(), ['prompt' => '']) ?>

    <?= $form->field($model, 'async')->checkbox() ?>

    <?= $form->field($model, 'guideline')->textarea(['rows' => 12]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
