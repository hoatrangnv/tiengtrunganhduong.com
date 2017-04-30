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
        exec("php yii backup/database -p=\"$p\" 2>&1", $output, $return);
        var_dump($return);
        if (is_file($return)) {
            Yii::$app->response->sendFile($return);
            unlink($return);
        } else {
            var_dump($output);
        }
    }

    public function actionImages()
    {
        chdir(dirname(Yii::getAlias('@backend')));
        exec("php yii backup/images 2>&1", $output, $return);
        if (is_file($return)) {
            Yii::$app->response->sendFile($return);
            unlink($return);
        } else {
            var_dump($output);
        }
    }

}