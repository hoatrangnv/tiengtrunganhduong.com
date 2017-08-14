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
    'modules' => [
        'quiz' => [
            'class' => 'common\modules\quiz\Module',
        ],
    ],
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
                // Site
                ['pattern' => '<' . UrlParam::AMP . ':amp>.htm', 'route' => 'site/index'],
                ['pattern' => '', 'route' => 'site/index'],
                ['pattern' => '/', 'route' => 'site/index'],
                ['pattern' => 'site/captcha', 'route' => 'site/captcha'],
                ['pattern' => 'lien-he.htm', 'route' => 'site/contact'],
                // Sitemap
                ['pattern' => 'sitemap.xml', 'route' => 'sitemap/index'],
                ['pattern' => 'sitemap-static.xml', 'route' => 'sitemap/static'],
                ['pattern' => 'sitemap-article-<' . UrlParam::PAGE . ':\d+>.xml', 'route' => 'sitemap/article'],
                // Quiz
                ['pattern' => 'quiz', 'route' => 'my-quiz/index'],
                ['pattern' => 'quiz/', 'route' => 'my-quiz/index'],
                ['pattern' => 'quiz/<' . UrlParam::SLUG . '>.htm', 'route' => 'my-quiz/play'],
                ['pattern' => 'quiz/facebook/get-user-data', 'route' => '/quiz/facebook/get-user-data'],
                ['pattern' => 'quiz/facebook/get-user-avatar', 'route' => '/quiz/facebook/get-user-avatar'],
                ['pattern' => 'quiz/facebook/canvas-image-to-url', 'route' => '/quiz/facebook/canvas-image-to-url'],

                // Article
                ['pattern' => 'article/ajax-get-items', 'route' => 'article/ajax-get-items'],
                ['pattern' => 'article/ajax-update-counter', 'route' => 'article/ajax-update-counter'],
                ['pattern' => 'tin-tuc.<' . UrlParam::AMP . ':amp>.htm', 'route' => 'article/index'],
                ['pattern' => 'tin-tuc.htm', 'route' => 'article/index'],
                ['pattern' => '<' . UrlParam::ALIAS . ':(.*(|[\/]).*)>/tags.htm', 'route' => 'article/tags'],
                ['pattern' => '<' . UrlParam::ALIAS . ':(.*(|[\/]).*)>/search.htm', 'route' => 'article/search'],
                // see: on beforeRequest
                // Crawler
                ['pattern' => '<' . UrlParam::ALIAS . ':(.*[\/].*)>', 'route' => 'crawler/view'],
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
        $catSlugs = implode('|', \yii\helpers\ArrayHelper::getColumn(\frontend\models\ArticleCategory::indexData(), 'slug'));
        $urlConfig =  [
            ['pattern' => '<' . UrlParam::SLUG . ':(' . $catSlugs . ')>.<' . UrlParam::AMP . ':amp>.htm', 'route' => 'article/category'],
            ['pattern' => '<' . UrlParam::SLUG . ':(' . $catSlugs . ')>.htm', 'route' => 'article/category'],

            ['pattern' => '<' . UrlParam::SLUG . '>.<' . UrlParam::AMP . ':amp>.htm', 'route' => 'article/view'],
            ['pattern' => '<' . UrlParam::SLUG . '>.htm', 'route' => 'article/view'],
        ];

        Yii::$app->urlManager->addRules($urlConfig, true);

    },
    'on afterRequest' => function ($event) {
    }
];
