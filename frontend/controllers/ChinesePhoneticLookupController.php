<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2/15/2020
 * Time: 9:47 AM
 */

namespace frontend\controllers;


class ChinesePhoneticLookupController extends BaseController
{
    public function actionIndex() {
        return $this->render('index');
    }
}