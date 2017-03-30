<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
//            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
            'identityClass' => 'mdm\admin\models\User',
//            'loginUrl' => ['admin/user/login'], // default: ['site/login']
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [],
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager', // or use 'yii\rbac\DbManager'
        ],
    ],
    'modules' => [
        'admin' => [
            'class' => 'mdm\admin\Module',
            'layout' => '@app/views/layouts/main.php',
            'controllerMap' => [
//                'assignment' => [
//                    'class' => 'mdm\admin\controllers\AssignmentController',
//                    'userClassName' => 'app\models\User',
//                    'idField' => 'user_id'
//                ],
//                'other' => [
//                    'class' => 'backend\controllers\UserController', // add another controller
//                ],
            ],
        ],
    ],
//    'aliases'   =>   [
//        '@mdm/admin'   =>   '@vendor/mdm/yii2-admin' ,
//    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'site/login',
            'site/logout',
            'site/error',
            'site/index',
            'admin/user/request-password-reset',
            'admin/user/reset-password',
//            'admin/user/signup',
        ]
    ],
    // follow config when redirect user to login form if not logged in
//    'as beforeRequest' => [  //if guest user access site so, redirect to login page.
//        'class' => 'yii\filters\AccessControl',
//        'rules' => [
//            [
//                'actions' => ['login', 'error', 'site'],
//                'allow' => true,
//            ],
//            [
//                'allow' => true,
//                'roles' => ['@'],
//            ],
//        ],
//    ],
    'params' => $params,
];
