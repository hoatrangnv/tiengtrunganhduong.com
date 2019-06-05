<?php
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use common\modules\audio\models\Audio;
use yii\helpers\Html;

$this->title = 'Upload Audios';
$this->params['breadcrumbs'][] = 'Upload';
$this->params['breadcrumbs'][] = 'Audios';

/**
 * @var $model \backend\models\UploadForm
 */
?>

<div class="upload-audios">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'audio_files[]')->fileInput(['multiple' => true, 'accept' => Audio::getValidAudioExtensions()]) ?>
    <button type="submit" class="btn btn-primary">Submit</button>

    <?php ActiveForm::end() ?>
</div>
