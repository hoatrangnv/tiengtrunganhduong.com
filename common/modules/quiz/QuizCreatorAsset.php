<?php

/**
 * Created by PhpStorm.
 * User: Quyet
 * Date: 7/11/2017
 * Time: 11:59 AM
 */

namespace common\modules\quiz;

use yii\web\AssetBundle;

class QuizCreatorAsset extends AssetBundle
{
    public $sourcePath = '@quiz/assets';

    public $css = [
        'css/quiz-creator.css'
    ];

    public $js = [
        ['js/quiz-creator.js', 'type' => 'text/babel'],
    ];

    public $depends = [
        '\common\modules\quiz\DefaultAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}