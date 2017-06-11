<?php
/**
 * Created by PhpStorm.
 * User: Quyet
 * Date: 4/1/2017
 * Time: 12:01 PM
 */

namespace backend\controllers;


use mdm\admin\components\Configs;
use yii\web\Controller;
use Yii;

class BaseController extends Controller
{

//    public function afterAction($action, $result)
//    {
//        if (!in_array($action->id, ['index', 'view'])) {
//            Yii::$app->cache->flush();
//        }
//        return parent::afterAction($action, $result);
//    }

}