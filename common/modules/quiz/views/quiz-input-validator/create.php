<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\modules\quiz\models\QuizInputValidator */

$this->title = 'Create Quiz Input Validator';
$this->params['breadcrumbs'][] = ['label' => 'Quiz Input Validators', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quiz-input-validator-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
