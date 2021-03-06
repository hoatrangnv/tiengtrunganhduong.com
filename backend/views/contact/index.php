<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\Contact;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ContactSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Contacts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contact-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <!--<p>
        <?/*= Html::a('Create Contact', ['create'], ['class' => 'btn btn-success']) */?>
    </p>-->
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
//            'updater_id',
            'name',
            'email:email',
            'subject',
            // 'body:ntext',
            // 'type',
             [
                 'attribute' => 'status',
                 'format' => 'raw',
                 'value' => function (Contact $model) {
                     $statuses = Contact::getStatuses();
                     if (isset($statuses[$model->status])) {
                         return $statuses[$model->status];
                     } else {
                         return $model->status;
                     }
                 }
             ],
             'create_time:datetime',
             'update_time:datetime',
            // 'creator_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
