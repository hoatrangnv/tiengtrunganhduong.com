<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\modules\audio\models\Audio;

/* @var $this yii\web\View */
/* @var $model common\modules\audio\models\Audio */
/* @var $form yii\widgets\ActiveForm */

$model->audio_name_to_basename = true;
?>

<div class="audio-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?php
    if (!$model->isNewRecord) {
        ?>
        <audio controls>
            <source src="<?= $model->getSource() ?>" type="<?= $model->mime_type ?>">
        </audio>
        <?php
    }
    ?>

    <?= $form->field($model, 'audio_file')->fileInput(['accept' => Audio::getValidAudioExtensions()]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'file_basename')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'audio_name_to_basename')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
