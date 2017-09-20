<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\NameTranslation;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\NameTranslationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Name Translations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="name-translation-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Name Translation', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'word',
            'translated_word',
            'spelling',
//            'meaning:ntext',
             'status',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($model) {
                    /**
                     * @var $model NameTranslation
                     */
                    $statuses = NameTranslation::getStatuses();
                    if (isset($statuses[$model->status])) {
                        return $statuses[$model->status];
                    } else {
                        return $model->status;
                    }
                },
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
