<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\RedirectedUrlSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Redirected Urls';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="redirected-url-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Redirected Url', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'from_url:ntext',
            'to_url:url',
             'active',
            // 'type',
            // 'status',
            // 'sort_order',
            // 'create_time:datetime',
            // 'update_time:datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
