<?php
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use backend\models\Image;
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

<?= $form->field($model, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>
<?= $form->field($model, 'quantity')->textInput() ?>
<?= $form->field($model, 'crop')->checkbox() ?>
<?php /*echo $form->field($model, 'resizeLabels')->widget(Select2::classname(), [
    'data' => \backend\models\Image::getSizes(),
    'options' => [
        'multiple' => true
    ],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);*/ ?>
<?= $form->field($model, 'resizeLabels')->dropDownList(Image::getSizes(), [
    'multiple' => 'multiple',
    'style' => 'min-height:' . (18 * count(Image::getSizes())) . 'px'
]) ?>
<?= $form->field($model, 'images_name')->textInput() ?>
<?= $form->field($model, 'images_name_to_basename')->checkbox() ?>
<?= $form->field($model, 'images_file_basename')->textInput() ?>
<?= $form->field($model, 'images_file_extension')->textInput() ?>
<button>Submit</button>

<?php ActiveForm::end() ?>