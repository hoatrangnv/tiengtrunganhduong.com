<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
//        'css/Skeleton-2.0.4/css/normalize.css',
//        'css/Skeleton-2.0.4/css/skeleton.css',
//        'css/Skeleton-2.0.4/css/custom.css',
        'css/me.css',
    ];
    public $js = [
        'js/main.js',
    ];
    public $depends = [
//        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];
}
