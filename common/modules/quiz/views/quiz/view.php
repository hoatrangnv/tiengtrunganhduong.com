<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\modules\quiz\models\Quiz */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Quizzes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quiz-view">

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
            'name',
            'slug',
            'introduction:ntext',
            'escape_html',
            'duration',
            'countdown_delay',
            'timeout_handling',
            'showed_stopwatches',
            'input_answers_showing',
            'description',
            'meta_title',
            'meta_description',
            'meta_keywords',
            'sort_order',
            'active',
            'visible',
            'doindex',
            'dofollow',
            'featured',
            'create_time:datetime',
            'update_time:datetime',
            'publish_time:datetime',
            'creator_id',
            'updater_id',
            'image_id',
            'quiz_category_id',
            'view_count',
            'like_count',
            'comment_count',
            'share_count',
        ],
    ]) ?>

</div>
