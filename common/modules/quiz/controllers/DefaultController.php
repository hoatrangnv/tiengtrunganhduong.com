<?php

namespace common\modules\quiz\controllers;

use yii\web\Controller;

/**
 * Default controller for the `quiz` module
 */
class DefaultController extends Controller
{
    public $layout = '@quiz/views/layouts/main';

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCreate()
    {
        return $this->render('create');
    }
}
