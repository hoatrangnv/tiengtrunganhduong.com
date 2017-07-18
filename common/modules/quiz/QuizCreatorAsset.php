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

    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];

    public $css = [
        'css/quiz-editor.css'
    ];

    public $js = [
        'js/react-sortable-hoc.js',
        ['js/quiz-editor.jsx', 'type' => 'text/babel'],
        'js/interact.js',
    ];

    public $depends = [
        '\common\modules\quiz\DefaultAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}