<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Articles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Article', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'creator_id',
            'updater_id',
            'category_id',
            'image_id',
            // 'slug',
            // 'name',
            // 'meta_title',
            // 'meta_keywords',
            // 'meta_description',
            // 'description',
            // 'content:ntext',
            // 'sub_content:ntext',
            // 'active',
            // 'visible',
            // 'hot',
            // 'sort_order',
            // 'status',
            // 'type',
            // 'create_time:datetime',
            // 'update_time:datetime',
            // 'publish_time:datetime',
            // 'views',
            // 'likes',
            // 'comments',
            // 'shares',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
