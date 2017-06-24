<?php

use yii\web\View;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\modules\image\models\Image;

/**
 * @var $this View
 * @var $model Image
 * @var $form ActiveForm
 */
?>

<div class="image-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'image_file')->fileInput(['accept' => Image::getValidImageExtensions()]) ?>

    <div class="label label-info">OR:</div>
    <?= $form->field($model, 'image_source')->textInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'file_basename')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'file_extension')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'input_resize_keys')->widget(Select2::className(), [
        'data' => array_merge([
            '50x50' => '50x50',
            '100x100' => '100x100',
            '150x150' => '150x150',
            '200x200' => '200x200',
            '250x250' => '250x250',
            '300x300' => '300x300',
            '350x350' => '350x350',
            '400x400' => '400x400',
        ], $model->input_resize_keys),
        'options' => [
            'multiple' => true,
            'placeholder' => 'Select...'
        ],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>

    <?= $form->field($model, 'sort_order')->textInput() ?>

    <?= $form->field($model, 'active')->checkbox() ?>

    <?= $form->field($model, 'quality')->textInput() ?>

    <?= $form->field($model, 'image_crop')->checkbox() ?>

    <?= $form->field($model, 'image_name_to_basename')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
