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
        'quiz-module' => [
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
                // Landing
                ['pattern' => 'khoa-hoc-tieng-trung-giao-tiep-co-ban-va-nang-cao.html', 'route' => 'course-registration/index'],
                ['pattern' => 'dang-ky-tu-van-khoa-hoc-thanh-cong.html', 'route' => 'course-registration/success'],
                ['pattern' => 'course-registration/ajax-save-contact', 'route' => 'course-registration/ajax-save-contact'],
                ['pattern' => 'course-registration/ajax-validate-contact', 'route' => 'course-registration/ajax-validate-contact'],
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
//                ['pattern' => 'quiz/<' . UrlParam::SLUG . '>.htm', 'route' => 'my-quiz/play'],
//                ['pattern' => 'quiz/facebook/get-user-data', 'route' => '/quiz/facebook/get-user-data'],
//                ['pattern' => 'quiz/facebook/get-user-avatar', 'route' => '/quiz/facebook/get-user-avatar'],
//                ['pattern' => 'my-quiz/get-sharing-data', 'route' => '/my-quiz/get-sharing-data'],
//                ['pattern' => 'my-quiz/remove-sharing-image', 'route' => '/my-quiz/remove-sharing-image'],
                // Quiz
                ['pattern' => 'ho-ten-tieng-trung-quoc-cua-ban.html', 'route' => 'name-translation/index'],
                ['pattern' => 'quiz', 'route' => 'quiz/index'],
                ['pattern' => 'quiz', 'route' => 'quiz/index', 'suffix' => '/'],
                ['pattern' => 'quiz/<' . UrlParam::SLUG . '>.htm', 'route' => 'quiz/play'],
                ['pattern' => 'quiz/get-sharing-data', 'route' => 'quiz/get-sharing-data'],
                ['pattern' => 'quiz/test-callback', 'route' => 'quiz/test-callback'],
                ['pattern' => 'quiz/ajax-update-counter', 'route' => 'quiz/ajax-update-counter'],
                ['pattern' => 'quiz/ajax-get-items', 'route' => 'quiz/ajax-get-items'],
                ['pattern' => 'quiz/translate-name', 'route' => 'quiz/translate-name'],
                ['pattern' => 'quiz-api/save-high-score', 'route' => 'quiz-api/save-high-score'],
                ['pattern' => 'quiz-api/get-high-score-result', 'route' => 'quiz-api/get-high-score-result'],

                // ChinesePhrasePhonetic
                ['pattern' => 'chinese-phrase-phonetic-api/lookup', 'route' => 'chinese-phrase-phonetic-api/lookup'],
                ['pattern' => 'dich-tieng-trung-tieng-viet-tra-cuu-phien-am-tieng-trung.html', 'route' => 'chinese-phonetic-lookup/index'],

                // User
                ['pattern' => 'user/get-facebook-data', 'route' => 'user/get-facebook-data'],
                ['pattern' => 'user/get-facebook-avatar', 'route' => 'user/get-facebook-avatar'],
                ['pattern' => 'user/login-with-facebook', 'route' => 'user/login-with-facebook'],

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
            'forceCopy' => true,
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
