<?php

return [
    'name' => 'tiengtrunganhduong.com',
    'charset' => 'UTF-8',
    'language' => 'vi',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'db' => [
            'charset' => 'utf8',
            'enableSchemaCache' => true,
            // Duration of schema cache.
            'schemaCacheDuration' => 3600,
            // Name of the cache component used to store schema information
            'schemaCache' => 'cache',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'cachePath' => '@common/runtime/cache',
            'dirMode' => 0777,
        ],
        'frontendUrlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [],
        ],
        'backendUrlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [],
        ],
    ],
    'aliases' => [
        '@quiz' => '@common/modules/quiz',
        '@mdm/admin' => '@backend/mdm.admin',
        '@frontendUrl' => 'https://tiengtrunganhduong.com',
        '@backendUrl' => 'https://tiengtrunganhduong.com/backend',
        '@imagesUrl' => 'https://tiengtrunganhduong.com/images',
        '@audiosUrl' => 'https://tiengtrunganhduong.com/audios',
        '@quizImagesUrl' => 'https://tiengtrunganhduong.com/quiz-images',
    ]
];
