<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\SeoInfo */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Seo Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seo-info-view">

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
            'url:url',
            'route',
            'name',
            'meta_title',
            'meta_keywords',
            'meta_description',
            'description',
            'long_description:ntext',
            'content:ntext',
            'active',
            'type',
            'status',
            'sort_order',
            'create_time:datetime',
            'update_time:datetime',
            'doindex',
            'dofollow',
        ],
    ]) ?>

</div>
