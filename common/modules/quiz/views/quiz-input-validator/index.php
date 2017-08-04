<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\quiz\searchModels\QuizInputValidator */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quiz Input Validators';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quiz-input-validator-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Quiz Input Validator', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'arguments',
            'quiz_fn_id',
            'quiz_id',
            // 'error_message',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
