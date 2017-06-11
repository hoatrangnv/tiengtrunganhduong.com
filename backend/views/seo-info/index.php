<?php

use yii\helpers\Html;
use yii\grid\GridView;

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

            'id',
            'creator_id',
            'updater_id',
            'image_id',
            'url:url',
            // 'route',
            // 'name',
            // 'meta_title',
            // 'meta_keywords',
            // 'meta_description',
            // 'description',
            // 'long_description:ntext',
            // 'content:ntext',
            // 'active',
            // 'type',
            // 'status',
            // 'sort_order',
            // 'create_time:datetime',
            // 'update_time:datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
