<?php
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use backend\models\Image;
use yii\helpers\Html;

$this->title = 'Upload File';
$this->params['breadcrumbs'][] = 'Upload';
$this->params['breadcrumbs'][] = 'Images';
?>

<div class="upload-images">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'file')->fileInput() ?>
    <button type="submit" class="btn btn-primary">Submit</button>

    <?php ActiveForm::end() ?>
</div>
