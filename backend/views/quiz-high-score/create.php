<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\QuizHighScore */

$this->title = 'Create Quiz High Score';
$this->params['breadcrumbs'][] = ['label' => 'Quiz High Scores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quiz-high-score-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
