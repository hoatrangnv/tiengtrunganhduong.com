<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'console\controllers',
    'controllerMap' => [
        'my-migrate' => [
            'class' => 'console\controllers\MyMigrateController',
            'templateFile' => '@console/views/migration.php',
            'generatorTemplateFiles' => [
                'create_table' => '@console/views/createTableMigration.php',
                'drop_table' => '@console/views/dropTableMigration.php',
                'add_column' => '@console/views/addColumnMigration.php',
                'drop_column' => '@console/views/dropColumnMigration.php',
                'create_junction' => '@console/views/createTableMigration.php',
            ]
        ],
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            'templateFile' => '@console/views/migration.php',
            'generatorTemplateFiles' => [
                'create_table' => '@console/views/createTableMigration.php',
                'drop_table' => '@console/views/dropTableMigration.php',
                'add_column' => '@console/views/addColumnMigration.php',
                'drop_column' => '@console/views/dropColumnMigration.php',
                'create_junction' => '@console/views/createTableMigration.php',
            ]
        ],

        'fixture' => [
            'class' => 'yii\console\controllers\FixtureController',
            'namespace' => 'common\fixtures',
          ],
    ],
    'components' => [
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager', // or use 'yii\rbac\PhpManager'
        ],
    ],
    'params' => $params,
];
