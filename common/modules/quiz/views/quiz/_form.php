<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\quiz\models\Quiz */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="quiz-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'introduction')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'duration')->textInput() ?>

    <?= $form->field($model, 'countdown_delay')->textInput() ?>

    <?= $form->field($model, 'timeout_handling')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'showed_stopwatches')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'input_answers_showing')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_keywords')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sort_order')->textInput() ?>

    <?= $form->field($model, 'active')->textInput() ?>

    <?= $form->field($model, 'visible')->textInput() ?>

    <?= $form->field($model, 'doindex')->textInput() ?>

    <?= $form->field($model, 'dofollow')->textInput() ?>

    <?= $form->field($model, 'featured')->textInput() ?>

    <?= $form->field($model, 'publish_time')->textInput() ?>

    <?= $form->field($model, 'image_id')->textInput() ?>

    <?= $form->field($model, 'quiz_category_id')->textInput() ?>

    <?= $form->field($model, 'view_count')->textInput() ?>

    <?= $form->field($model, 'like_count')->textInput() ?>

    <?= $form->field($model, 'comment_count')->textInput() ?>

    <?= $form->field($model, 'share_count')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
