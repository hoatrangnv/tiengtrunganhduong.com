<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\modules\quiz\models\QuizFn */

$this->title = 'Create Quiz Fn';
$this->params['breadcrumbs'][] = ['label' => 'Quiz Fns', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quiz-fn-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
