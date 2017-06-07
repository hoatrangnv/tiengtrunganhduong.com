<?php
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\bootstrap\Nav;

NavBar::begin([
    'brandLabel' => '<strong>' . Yii::$app->name . '</strong>',
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-inverse navbar-fixed-top',
    ],
]);

$menuItems = [
    ['label' => 'Home', 'url' => ['/site/index']],
    ['label' => 'Article', 'items' => [
        ['label' => 'Index', 'url' => ['/article/index']],
        ['label' => 'Create', 'url' => ['/article/create']],
        ['label' => 'Update', 'url' => ['/article/update'], 'visible' => false],
        ['label' => 'View', 'url' => ['/article/view'], 'visible' => false],
    ]],
    ['label' => 'Article Category', 'items' => [
        ['label' => 'Index', 'url' => ['/article-category/index']],
        ['label' => 'Create', 'url' => ['/article-category/create']],
        ['label' => 'Update', 'url' => ['/article-category/update'], 'visible' => false],
        ['label' => 'View', 'url' => ['/article-category/view'], 'visible' => false],
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
        ['label' => 'Users', 'url' => ['/admin/user/index']],
        ['label' => 'Users', 'url' => ['/admin/user/update'], 'visible' => false],
        ['label' => 'Users', 'url' => ['/admin/user/view'], 'visible' => false],

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
];

echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => $menuItems,
]);

NavBar::end();
