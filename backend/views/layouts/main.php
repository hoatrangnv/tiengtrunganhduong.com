<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use mdm\admin\components\MenuHelper;
use mdm\admin\components\Helper;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => 'Home', 'url' => ['/site/index']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Login', 'url' => ['/admin/user/login']];
    } else {
        $menuItems = array_merge(
            $menuItems,
            Helper::filter([
                ['label' => 'Article', 'items' => [
                    ['label' => 'Index', 'url' => ['/article/index']],
                    ['label' => 'Create', 'url' => ['/article/create']],
                    ['label' => 'Update', 'url' => ['/article/update'], 'visible' => false],
                    ['label' => 'View', 'url' => ['/article/view'], 'visible' => false],
                ]],
                ['label' => 'Image', 'items' => [
                    ['label' => 'Index', 'url' => ['/image/index']],
                    ['label' => 'Create', 'url' => ['/image/create']],
                    ['label' => 'Upload Multiple', 'url' => ['/upload/images']],
                    ['label' => 'Update', 'url' => ['/image/update'], 'visible' => false],
                    ['label' => 'View', 'url' => ['/image/view'], 'visible' => false],
                ]],
                ['label' => 'Admin', 'items' => [
                    ['label' => '+User', 'url' => ['/admin/user/signup']],

                    ['label' => 'Assignment', 'url' => ['/admin/assignment/index']],
                    ['label' => 'Assignment', 'url' => ['/admin/assignment/view'], 'visible' => false],
                    ['label' => 'Assignment', 'url' => ['/admin/assignment/create'], 'visible' => false],
                    ['label' => 'Assignment', 'url' => ['/admin/assignment/update'], 'visible' => false],
                    
                    ['label' => 'Permission', 'url' => ['/admin/permission/index']],
                    ['label' => 'Permission', 'url' => ['/admin/permission/view'], 'visible' => false],
                    ['label' => 'Permission', 'url' => ['/admin/permission/create'], 'visible' => false],
                    ['label' => 'Permission', 'url' => ['/admin/permission/update'], 'visible' => false],
                    
                    ['label' => 'Role', 'url' => ['/admin/role/index']],
                    ['label' => 'Role', 'url' => ['/admin/role/view'], 'visible' => false],
                    ['label' => 'Role', 'url' => ['/admin/role/create'], 'visible' => false],
                    ['label' => 'Role', 'url' => ['/admin/role/update'], 'visible' => false],
                    
                    ['label' => 'Route', 'url' => ['/admin/route/index']],
                    ['label' => 'Route', 'url' => ['/admin/route/view'], 'visible' => false],
                    ['label' => 'Route', 'url' => ['/admin/route/create'], 'visible' => false],
                    ['label' => 'Route', 'url' => ['/admin/route/update'], 'visible' => false],
                    
                    ['label' => 'Rule', 'url' => ['/admin/rule/index']],
                    ['label' => 'Rule', 'url' => ['/admin/rule/view'], 'visible' => false],
                    ['label' => 'Rule', 'url' => ['/admin/rule/create'], 'visible' => false],
                    ['label' => 'Rule', 'url' => ['/admin/rule/update'], 'visible' => false],

                    ['label' => 'Menu', 'url' => ['/admin/menu/index']],
                    ['label' => 'Menu', 'url' => ['/admin/menu/view'], 'visible' => false],
                    ['label' => 'Menu', 'url' => ['/admin/menu/create'], 'visible' => false],
                    ['label' => 'Menu', 'url' => ['/admin/menu/update'], 'visible' => false],
                ]],
                ['label' => 'User', 'url' => ['/user/index']],
            ]),
            [
                ['label' => \Yii::$app->user->identity->username, 'items' => [
                    ['label' => 'Change Password', 'url' => ['/admin/user/change-password']],
                    [
                        'label' => 'Logout',
                        'url' => ['/admin/user/logout'],
                        'linkOptions' => ['data-method' => 'post']
                    ]
                ]],
            ]
        );
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'activateParents' => true,
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Yii::$app->name ?> <?= date('Y') ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
