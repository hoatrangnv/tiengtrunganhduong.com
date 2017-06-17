<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Article */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<!--
<?= $model->templateLogMessage ?>
-->
<div class="article-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Code Update', ['update', 'id' => $model->id, 'code_editor' => 1], ['class' => 'btn btn-primary']) ?>
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
            'category_id',
            'slug',
            'name',
            'meta_title',
            'meta_description',
            'meta_keywords',
            'description',
            'content:ntext',
            'sub_content:ntext',
            'active',
            'visible',
            'featured',
            'type',
            'status',
            'sort_order',
            'create_time:datetime',
            'update_time:datetime',
            'publish_time:datetime',
            'view_count',
            'like_count',
            'comment_count',
            'share_count',
            'doindex',
            'dofollow',
            'menu_label',
        ],
    ]) ?>

</div>
