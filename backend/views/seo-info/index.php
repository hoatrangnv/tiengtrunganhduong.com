<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\SeoInfo;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SeoInfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Seo Infos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seo-info-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Seo Info', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
//            'creator_id',
//            'updater_id',
            [
                'attribute' => 'image_id',
                'format' => 'raw',
                'value' => function (SeoInfo $model) {
                    return $model->img('100x100');
                }
            ],
//            'url:url',
            [
                'attribute' => 'route',
                'format' => 'raw',
                'value' => function (SeoInfo $model) {
                    $routes = SeoInfo::getRoutes();
                    return $model->route . (isset($routes[$model->route]) ? ' (' . $routes[$model->route] . ')' : '');
                }
            ],
             'name',
            // 'meta_title',
            // 'meta_keywords',
            // 'meta_description',
            // 'description',
            // 'long_description:ntext',
            // 'content:ntext',
            // 'type',
            // 'status',
             'sort_order',
             'active:boolean',
            // 'create_time:datetime',
            // 'update_time:datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
