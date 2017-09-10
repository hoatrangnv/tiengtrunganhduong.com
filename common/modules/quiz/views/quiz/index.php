<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\quiz\searchModels\Quiz */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quizzes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quiz-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Quiz', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            [
                'attribute' => 'image_id',
                'format' => 'raw',
                'value' => function (\common\modules\quiz\models\Quiz $model) {
                    return $model->img('50x50');
                }
            ],
            'name',
//            'slug',
            'introduction',
            'escape_html:boolean',
            // 'duration',
            // 'countdown_delay',
            // 'timeout_handling',
            // 'showed_stopwatches',
            // 'input_answers_showing',
            // 'description',
            // 'meta_title',
            // 'meta_description',
            // 'meta_keywords',
            // 'sort_order',
             'active:boolean',
            // 'visible',
            // 'doindex',
            // 'dofollow',
            // 'featured',
//             'create_time:datetime',
            // 'update_time:datetime',
             'publish_time:datetime',
            // 'creator_id',
            // 'updater_id',
            // 'image_id',
            // 'quiz_category_id',
             'view_count',
//             'like_count',
//             'comment_count',
            // 'share_count',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {view} {delete}',
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-pencil"></span>',
                            \yii\helpers\Url::to(['default/update', 'id' => $model->id])
                        );
                    }
                ],
            ],
        ],
    ]); ?>
</div>
