<?php

/**
 * Created by PhpStorm.
 * User: Quyet
 * Date: 7/11/2017
 * Time: 11:59 AM
 */

namespace common\modules\quiz;

use yii\web\AssetBundle;

class QuizPlayAsset extends AssetBundle
{
    public $sourcePath = '@quiz/assets';

    public $jsOptions = ['position' => \yii\web\View::POS_END];

    public $css = [
        'css/quiz-play-bundle.css',
    ];

    public $js = [
        'js/quiz-play-bundle.js',
    ];

    public $depends = [
        '\common\modules\quiz\DefaultAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];
}