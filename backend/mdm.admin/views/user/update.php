<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \mdm\admin\models\User */

$this->title = Yii::t('app', 'Update');
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-change']); ?>
            <?= $form->field($model, 'pen_name')->textInput() ?>
            <?= $form->field($model, 'status')->dropDownList(\backend\models\User::statusLabels(), ['prompt' => '--Select--']) ?>
            <?= $form->field($model, 'type')->dropDownList(\backend\models\User::typeLabels(), ['prompt' => '--Select--']) ?>
            <?= $form->field($model, 'reset_password')->passwordInput() ?>
            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary', 'name' => 'change-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
