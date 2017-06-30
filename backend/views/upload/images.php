<?php
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use backend\models\Image;
use yii\helpers\Html;

$this->title = 'Upload Images';
$this->params['breadcrumbs'][] = 'Upload';
$this->params['breadcrumbs'][] = 'Images';

$module = Yii::$app->modules['image2'];
?>

<div class="upload-images">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'image_files[]')->fileInput(['multiple' => true, 'accept' => Image::getValidImageExtensions()]) ?>
    <?= $form->field($model, 'image_resize_labels')->dropDownList($module->params['input_resize_keys'], [
        'multiple' => 'multiple',
        'style' => 'height:' . (18 * count($module->params['input_resize_keys'])) . 'px;max-height:600px'
    ]) ?>
    <?= $form->field($model, 'image_crop')->checkbox() ?>
    <?= $form->field($model, 'image_quality')->textInput() ?>
    <?= $form->field($model, 'image_name')->textInput() ?>
    <?= $form->field($model, 'image_name_to_basename')->checkbox() ?>
    <?= $form->field($model, 'image_file_basename')->textInput() ?>
    <?= $form->field($model, 'image_file_extension')->textInput() ?>
    <button type="submit" class="btn btn-primary">Submit</button>

    <?php ActiveForm::end() ?>
</div>
