<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\QuizHighScore */

$this->title = 'Update Quiz High Score: ' . $model->quiz_id;
$this->params['breadcrumbs'][] = ['label' => 'Quiz High Scores', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->quiz_id, 'url' => ['view', 'quiz_id' => $model->quiz_id, 'user_id' => $model->user_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="quiz-high-score-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
