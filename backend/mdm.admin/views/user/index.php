<?php

use yii\helpers\Html;
use yii\grid\GridView;
use mdm\admin\components\Helper;

/* @var $this yii\web\View */
/* @var $searchModel mdm\admin\models\searchs\User */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('rbac-admin', 'Users');
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
            'create_time:date',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return $model->status;
                },
                'filter' => \mdm\admin\models\User::statusLabels()
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => Helper::filterActionColumn(['view', 'update', 'delete']),
//                'buttons' => [
//                    'activate' => function($url, $model) {
//                        if ($model->status == \mdm\admin\models\searchs\User::STATUS_ACTIVE) {
//                            return '';
//                        }
//                        $options = [
//                            'title' => Yii::t('rbac-admin', 'Activate'),
//                            'aria-label' => Yii::t('rbac-admin', 'Activate'),
//                            'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to activate this user?'),
//                            'data-method' => 'post',
//                            'data-pjax' => '0',
//                        ];
//                        return Html::a('<span class="glyphicon glyphicon-ok"></span>', $url, $options);
//                    }
//                    ]
                ],
            ],
        ]);
        ?>
</div>
