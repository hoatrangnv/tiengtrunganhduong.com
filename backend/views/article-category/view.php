<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\ArticleCategory */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Article Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-category-view">

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
            'image_id',
            'parent_id',
            'slug',
            'name',
            'meta_title',
            'meta_description',
            'meta_keywords',
            'description',
            'long_description:ntext',
            'active',
            'visible',
            'featured',
            'type',
            'status',
            'sort_order',
            'create_time:datetime',
            'update_time:datetime',
            'doindex',
            'dofollow',
            'menu_label',
        ],
    ]) ?>

</div>
