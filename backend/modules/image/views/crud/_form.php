<?php

use yii\web\View;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\modules\image\models\Image;
use yii\helpers\Url;

/**
 * @var $this View
 * @var $model Image
 * @var $form ActiveForm
 */
?>
<style>
    #image-preview-wrapper img {
        display: block;
        max-width: 100%;
        max-height: 200px;
        width: auto;
        height: auto;
    }
</style>
<div class="image-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div id="image-preview-wrapper">
        <?= $model->img() ?>
    </div>

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

    <?= $form->field($model, 'input_resize_keys')->dropDownList(array_merge([
        '' => '',
        '50x50' => '50x50',
        '100x100' => '100x100',
        '150x150' => '150x150',
        '200x200' => '200x200',
        '250x250' => '250x250',
        '300x300' => '300x300',
        '350x350' => '350x350',
        '400x400' => '400x400',
    ], $model->input_resize_keys), [
        'multiple' => 'multiple',
        'size' => '10',
    ]) ?>

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
<script>
    var img_preview = document.getElementById("image-preview-wrapper");
    var img_input = document.getElementById("<?= Html::getInputId($model, 'image_file') ?>");
    var img_source = document.getElementById("<?= Html::getInputId($model, 'image_source') ?>");
    var last_img_src = img_preview.querySelector("img") ? img_preview.querySelector("img").src : "";
    img_preview.empty = function () {
        while(img_preview.firstChild) {
            img_preview.removeChild(img_preview.firstChild);
        }
    };
    img_source.addEventListener("change", function (event) {
        var image = new Image();
        if (img_source.value) {
            image.src = img_source.value;
            image.addEventListener("load", function () {
                img_preview.empty();
                img_preview.appendChild(image);
            });
            image.addEventListener("error", function (event) {
                image.src = last_img_src;
                var msg = document.createElement("span");
                msg.className = "text-danger";
                msg.innerHTML = "Cannot load image source.";
                img_preview.empty();
                img_preview.appendChild(image);
                img_preview.appendChild(msg);
            });
        } else {
            image.src = last_img_src;
            img_preview.empty();
            img_preview.appendChild(image);
        }
    });
    img_input.addEventListener("change", function (event) {
        var reader = new FileReader();
        var file = this.files[0];
        // @TODO: Read image file as URL

        if (reader.readAsDataURL) {
            reader.readAsDataURL(file);
        } else if (reader.readAsDataurl) {
            reader.readAsDataurl(file);
        } else {
            throw "Browser does not support.";
        }

        // @TODO: Append image preview
        var image = new Image();
        reader.addEventListener("load", function () {
            image.src = reader.result;
            img_preview.empty();
            img_preview.appendChild(image);
            last_img_src = image.src;
        });
    });
</script>