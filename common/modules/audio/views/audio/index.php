<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\audio\searchModels\Audio */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Audios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="audio-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Audio', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'path',
            'file_basename',
            'file_extension',
            // 'mime_type',
            // 'duration',
            // 'quality',
            // 'create_time:datetime',
            // 'update_time:datetime',
            // 'creator_id',
            // 'updater_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
