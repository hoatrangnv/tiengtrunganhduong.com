<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\quiz\models\QuizSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quizzes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quiz-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Quiz', ['default/create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'name',
            'slug',
            'description',
//            'meta_title',
            // 'meta_description',
            // 'meta_keywords',
            // 'sort_order',
            // 'active',
            // 'visible',
            // 'doindex',
            // 'dofollow',
            // 'featured',
             'create_time:datetime',
            // 'update_time:datetime',
//             'publish_time:datetime',
            // 'creator_id',
            // 'updater_id',
            // 'image_id',
            // 'quiz_category_id',

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
