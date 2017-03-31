<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Article */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'creator_id',
            'updater_id',
            'category_id',
            'image_id',
            'slug',
            'name',
            'meta_title',
            'meta_keywords',
            'meta_description',
            'description',
            'content:ntext',
            'sub_content:ntext',
            'active',
            'visible',
            'hot',
            'status',
            'type',
            'sort_order',
            'create_time:datetime',
            'update_time:datetime',
            'publish_time:datetime',
            'views',
            'likes',
            'comments',
            'shares',
        ],
    ]) ?>

</div>
