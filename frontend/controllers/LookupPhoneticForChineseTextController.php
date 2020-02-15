<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2/15/2020
 * Time: 9:47 AM
 */

namespace frontend\controllers;


class LookupPhoneticForChineseTextController extends BaseController
{
    public function actionIndex() {
        return $this->render('index', [
            'search' => \Yii::$app->request->get('search', '')
        ]);
    }
}