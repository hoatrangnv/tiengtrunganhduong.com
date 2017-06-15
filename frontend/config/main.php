<?php
use common\models\UrlParam;

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'baseUrl' => '',
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'frontend\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
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
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                // Home page
                ['pattern' => '', 'route' => 'site/index'],
                ['pattern' => '/', 'route' => 'site/index'],
                // Contact
                ['pattern' => 'lien-he.htm', 'route' => 'site/contact'],
                // Sitemap
                ['pattern' => 'sitemap.xml', 'route' => 'sitemap/index'],
                ['pattern' => 'sitemap-static.xml', 'route' => 'sitemap/static'],
                ['pattern' => 'sitemap-article-<' . UrlParam::PAGE . ':\d+>.xml', 'route' => 'sitemap/article'],
                // Article
                // see: on beforeRequest
            ],
        ],
        'assetManager' => [
            'appendTimestamp' => true,
            'bundles' => [
                \yii\bootstrap\BootstrapAsset::className() => [
                    'css' => [],
                ],
                \yii\web\YiiAsset::className() => [
                    'js' => [],
                ],
                \yii\web\JqueryAsset::className() => [
                    'js' => [],
                ],
                \yii\bootstrap\BootstrapPluginAsset::className() => [
                    'js' => [],
                ],
            ],
        ],
    ],
    'params' => $params,
    'on beforeRequest' => function ($event) {
        // Article URL config
        $urlConfig =  [
            ['pattern' => '<' . UrlParam::ALIAS . '>/tags.htm', 'route' => 'article/tag'],
            ['pattern' => '<' . UrlParam::SLUG . ':('
                . implode('|', \yii\helpers\ArrayHelper::getColumn(
                    \frontend\models\ArticleCategory::indexData(), 'slug'))
                . ')>.htm', 'route' => 'article/category'],
            ['pattern' => '<' . UrlParam::SLUG . '>.htm', 'route' => 'article/view'],
        ];

        Yii::$app->urlManager->addRules($urlConfig, true);

    },
    'on afterRequest' => function ($event) {

    }
];
