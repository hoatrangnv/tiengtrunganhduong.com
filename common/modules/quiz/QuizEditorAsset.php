<?php

/**
 * Created by PhpStorm.
 * User: Quyet
 * Date: 7/11/2017
 * Time: 11:59 AM
 */

namespace common\modules\quiz;

use yii\web\AssetBundle;

class QuizEditorAsset extends AssetBundle
{
    public $sourcePath = '@common/modules/quiz/assets';

    public $jsOptions = ['position' => \yii\web\View::POS_END];

    public $css = [
        'css/quiz-editor-bundle.css',
    ];

    public $js = [
        'js/quiz-editor-bundle.js',
    ];

    public $depends = [
//        '\common\modules\quiz\DefaultAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];
}