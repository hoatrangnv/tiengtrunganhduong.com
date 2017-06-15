<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = Yii::t('app', 'Contact');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Yii::t('app', 'If you have business inquiries or other questions, please fill out the following form to contact us. Thank you.') ?>
    </p>
    <br>
    <?php $form = ActiveForm::begin(['id' => 'contact-form', 'options' => ['class' => 'primary']]); ?>

        <?= $form->field($model, 'name', ['template' => '{input}{label}'])->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'email', ['template' => '{input}{label}']) ?>

        <?= $form->field($model, 'phone_number', ['template' => '{input}{label}']) ?>

        <?= $form->field($model, 'subject', ['template' => '{input}{label}']) ?>

        <?= $form->field($model, 'body', ['template' => '{input}{label}'])->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'verifyCode', ['template' => '{input}{label}'])->widget(Captcha::className(), [
            'template' => '{input}{image}',
        ]) ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
