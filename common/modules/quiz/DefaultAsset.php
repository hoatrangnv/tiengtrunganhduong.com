<?php

/**
 * Created by PhpStorm.
 * User: Quyet
 * Date: 7/11/2017
 * Time: 11:25 AM
 */

namespace common\modules\quiz;

use yii\web\AssetBundle;

class DefaultAsset extends AssetBundle
{
    public $sourcePath = '@quiz/assets';

    public $css = [
        'css/site.css',
    ];

    public $js = [
        'js/react-with-addons.js',
        'js/react-dom-v15.5.4.js',
        'js/babel-core.min.js',
    ];
}