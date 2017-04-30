<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 4/30/2017
 * Time: 11:59 PM
 */

namespace backend\controllers;

use Yii;

class BackupController extends BaseController
{
    public function actionDatabase($p)
    {
        chdir(dirname(Yii::getAlias('@backend')));
        $filename = exec("php yii backup/database -p=\"$p\"", $output, $return);
        if (is_file($filename)) {
            Yii::$app->response->sendFile($filename);
        } else {
            var_dump($output);
        }
    }

    public function actionImages()
    {
        chdir(dirname(Yii::getAlias('@backend')));
        $filename = exec("php yii backup/images", $output, $return);
        if (is_file($filename)) {
            Yii::$app->response->sendFile($filename);
        } else {
            var_dump($output);
        }
    }

}