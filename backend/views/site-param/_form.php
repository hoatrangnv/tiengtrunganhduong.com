<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\SiteParam */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="site-param-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->dropDownList(
        \backend\models\SiteParam::getTypes(), ['prompt' => \Yii::t('app', 'Select one ...')]) ?>

    <?= $form->field($model, 'value')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'active')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
//    !function (editor) {
//        editor && ckeditor(editor);
//    }(document.getElementById("<?//= Html::getInputId($model, 'value') ?>//"));
</script>
