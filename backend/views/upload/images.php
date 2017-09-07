<?php
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use common\modules\image\models\Image;
use yii\helpers\Html;

$this->title = 'Upload Images';
$this->params['breadcrumbs'][] = 'Upload';
$this->params['breadcrumbs'][] = 'Images';

$module = Yii::$app->modules['image2'];

/**
 * @var $model \backend\models\UploadForm
 */
?>

<div class="upload-images">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'image_files[]')->fileInput(['multiple' => true, 'accept' => Image::getValidImageExtensions()]) ?>
    <?= $form->field($model, 'image_crop')->checkbox() ?>
    <?= $form->field($model, 'image_quality')->textInput(['placeholder' => 'Default: 60/100']) ?>
    <button type="submit" class="btn btn-primary">Submit</button>

    <?php ActiveForm::end() ?>
</div>
