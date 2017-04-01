<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use trntv\aceeditor\AceEditor;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\Article */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php //echo $form->field($model, 'category_id')->textInput() ?>

    <?= $form->field($model, 'image_id')->widget(Select2::classname(), [
        'data' => \backend\models\Image::listAsId2Name(),
        'options' => [
            'multiple' => false,
            'placeholder' => 'Select...'
        ],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_keywords')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->widget(
        AceEditor::className(),
        [
            'mode' => 'php', // programing language mode. Default "html"
            'theme' => 'tomorrow_night_eighties', // editor theme. Default "github"
            'containerOptions' => [
                'style' => 'width:100%;min-height:400px;font-size:14px'
            ]
        ]
    ) ?>

    <?= $form->field($model, 'sub_content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'active')->textInput() ?>

    <?= $form->field($model, 'visible')->textInput() ?>

    <?= $form->field($model, 'hot')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'type')->textInput() ?>

    <?= $form->field($model, 'sort_order')->textInput() ?>

    <?= $form->field($model, 'publish_time')->textInput() ?>

    <?= $form->field($model, 'views')->textInput() ?>

    <?= $form->field($model, 'likes')->textInput() ?>

    <?= $form->field($model, 'comments')->textInput() ?>

    <?= $form->field($model, 'shares')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
