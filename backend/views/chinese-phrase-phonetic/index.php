<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ChinesePhrasePhoneticSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Chinese Phrase Phonetics';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="chinese-phrase-phonetic-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Chinese Phrase Phonetic', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'phrase',
            'phonetic',
            'vi_phonetic',
            'meaning:ntext',
            'type',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
