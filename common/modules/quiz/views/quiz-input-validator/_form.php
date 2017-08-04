<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\modules\quiz\models\QuizFn;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\modules\quiz\models\QuizInputValidator */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="quiz-input-validator-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'arguments')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'quiz_fn_id')->dropDownList(
        ArrayHelper::map(QuizFn::find()->all(), 'id', 'name'),
        ['prompt' => 'Select One']
    ) ?>

    <?= $form->field($model, 'error_message')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
