<?php

return [
    'name' => 'vanquyet.com',
    'charset' => 'UTF-8',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'db' => [
            'charset' => 'utf8',
            'enableSchemaCache' => false,
            // Duration of schema cache.
            'schemaCacheDuration' => 3600,
            // Name of the cache component used to store schema information
            'schemaCache' => 'cache',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
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
        '@mdm/admin' => '@backend/mdm.admin',
        '@frontendUrl' => 'http://tiengtrunganhduong.com',
        '@backendUrl' => 'http://tiengtrunganhduong.com/backend',
        '@imagesUrl' => 'http://tiengtrunganhduong.com/images',
    ]
];
