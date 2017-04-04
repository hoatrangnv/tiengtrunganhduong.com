<?php

use yii\helpers\Html;
use yii\grid\GridView;
use mdm\admin\components\Helper;

/* @var $this yii\web\View */
/* @var $searchModel mdm\admin\models\searchs\User */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'username',
            'email:email',
            'created_at:date',
            [
                'attribute' => 'status',
                'value' => function($model) {
                    return $model->status == \mdm\admin\models\User::STATUS_ACTIVE ? 'Active' : 'Inactive';
                },
                'filter' => [
                    \mdm\admin\models\User::STATUS_INACTIVE => 'Inactive',
                    \mdm\admin\models\User::STATUS_ACTIVE => 'Active'
                ]
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => Helper::filterActionColumn(['update', 'delete']),
                'buttons' => [
                    'delete' => function($url, $model) {
                        if ($model->id == Yii::$app->user->id) {
                            return '';
                        }
                        $options = [
                            'title' => Yii::t('app', 'Delete'),
                            'aria-label' => Yii::t('app', 'Delete'),
                            'data-confirm' => Yii::t('app', 'Are you sure you want to delete this user?'),
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ];
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, $options);
                    }
                ],
            ],
        ],
    ]);
    ?>
</div>
