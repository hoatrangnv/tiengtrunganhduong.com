<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\quiz\models\QuizInputValidator */

$this->title = 'Update Quiz Input Validator: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Quiz Input Validators', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="quiz-input-validator-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
