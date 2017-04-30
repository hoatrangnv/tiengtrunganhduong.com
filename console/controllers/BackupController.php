<?php

namespace console\controllers;

use yii\console\Controller;

class BackupController extends Controller
{
    public $mysql_pwd;
    public function actionDb()
    {
        $filename = \Yii::getAlias('@backups/' . date('Ymd') . '/db.sql');
        exec(
            "mysqldump -P 3306 -h 127.6.245.2 -u adminRxtAczm -p quyettran_com --password=\"{$this->mysql_pwd}\" >db/$filename",
            $output
        );
        if ($output == '') {
            /* no output is good */
            echo $filename;
        } else {
            /* we have something to log the output here*/
            echo $output;
        }
    }
}