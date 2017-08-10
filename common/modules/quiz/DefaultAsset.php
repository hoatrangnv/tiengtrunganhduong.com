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
    ];
}