<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'name' => 'My Application',
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            'baseUrl' => '',
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
            'identityClass' => 'mdm\admin\models\User',
            'loginUrl' => ['admin/user/login'], // default: ['site/login']
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
            'rules' => [
                ['pattern' => '', 'route' => 'site/index'],
                ['pattern' => '/', 'route' => 'site/index'],
            ],
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager', // or use 'yii\rbac\PhpManager'
        ],
        'assetManager' => [
            'class' => 'yii\web\AssetManager',
            'appendTimestamp' => true,
            'forceCopy' => true,
        ]
    ],
    'modules' => [
        'quiz' => [
            'class' => 'common\modules\quiz\Module',
        ],
        'image2' => [
            'class' => 'common\modules\image\Module',
        ],
        'audio' => [
            'class' => 'common\modules\audio\Module',
        ],
        'my-gii' => [
            'class' => 'common\modules\gii\Module',
        ],
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
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
//            '*',
//            'site/error',
//            'site/index',
            'admin/user/login',
            'admin/user/logout',
            'admin/user/request-password-reset',
            'admin/user/reset-password',
            //Users can sign up by themselves, but status will be inactive (config default status in params)
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
