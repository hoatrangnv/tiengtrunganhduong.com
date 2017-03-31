<?php
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use backend\models\Image;
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

<?= $form->field($model, 'image_files[]')->fileInput(['multiple' => true, 'accept' => Image::getValidExtensions()]) ?>
<?= $form->field($model, 'image_resize_labels')->dropDownList(Image::getSizes(), [
    'multiple' => 'multiple',
    'style' => 'height:' . (18 * count(Image::getSizes())) . 'px;max-height:600px'
]) ?>
<?= $form->field($model, 'image_crop')->checkbox() ?>
<?= $form->field($model, 'image_quality')->textInput() ?>
<?= $form->field($model, 'image_name')->textInput() ?>
<?= $form->field($model, 'image_name_to_basename')->checkbox() ?>
<?= $form->field($model, 'image_file_basename')->textInput() ?>
<?= $form->field($model, 'image_file_extension')->textInput() ?>
<button type="submit" class="btn btn-primary">Submit</button>

<?php ActiveForm::end() ?>