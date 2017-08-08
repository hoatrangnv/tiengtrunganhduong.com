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
    public $sourcePath = '@quiz/assets';

    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];

    public $css = [
//        'css/react-select.css',
//        'css/quiz-editor.css',
//        'http://localhost:8000/index.css',
    ];

    public $js = [
//        'js/create-react-class.js',
//        'js/classnames.js',
//        'js/react-input-autosize.js',
//        'js/react-select.js',
//        'js/common.js',
//        'js/app.js',
//        '//cdn.ckeditor.com/4.6.1/standard/ckeditor.js',
//        'js/react-sortable-hoc.js',
//        ['js/ckeditor.jsx', 'type' => 'text/babel'],
//        ['js/index.js'],

//        'http://localhost:8000/common.js',
//        'http://localhost:8000/index.js',
//        'js/bundle.js',
        'http://localhost:3000/static/js/bundle.js',
    ];

    public $depends = [
        '\common\modules\quiz\DefaultAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];
}