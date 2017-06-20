<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\UrlRedirection;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UrlRedirectionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Url Redirections';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="url-redirection-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Url Redirection', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'from_url',
            'to_url',
            'active:boolean',
            [
                'attribute' => 'type',
                'format' => 'raw',
                'value' => function (UrlRedirection $model) {
                    $types = UrlRedirection::getTypes();
                    return isset($types[$model->type]) ? $types[$model->type] : $model->type;
                },
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'category_id',
                    UrlRedirection::getTypes(),
                    ['class'=>'form-control', 'prompt' => Yii::t('app', 'Select one ...')]
                )
            ],
            // 'status',
             'sort_order',
            // 'create_time:datetime',
            // 'update_time:datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
