<?php
/**
 * Created by PhpStorm.
 * User: Quyet
 * Date: 11/23/2017
 * Time: 10:06 AM
 */

namespace frontend\controllers;

use frontend\models\NameTranslation;
use Yii;

class NameTranslationController extends BaseController
{
    public function actionIndex()
    {
        return $this->render('index', [
            'search' => Yii::$app->request->get('search', '')
        ]);
    }
}