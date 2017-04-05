<?php

return [
    'name' => 'quyettran.com',
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
    'aliases' =>
        (!isset($_SERVER, $_SERVER['HTTP_HOST']) ||
            !$protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https://' : 'http://')
        )
        ? []
        : [
            '@frontendUrl' => $protocol . $_SERVER['HTTP_HOST'],
            '@backendUrl' => $protocol . $_SERVER['HTTP_HOST'] . '/backend',
            '@imagesUrl' => $protocol . $_SERVER['HTTP_HOST'] . '/images',
        ],
];
