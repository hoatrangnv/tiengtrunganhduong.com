<?php

namespace console\controllers;

use yii\console\Controller;

class BackupController extends Controller
{
    public $mysql_pwd;
    public function options($actionID)
    {
        $result = [];
        switch ($actionID) {
            case 'db':
                $result = ['mysql_pwd'];
                break;
            default:
                break;
        }
        return $result;
    }
    public function optionAliases()
    {
        return ['p' => 'mysql_pwd'];
    }
    public function actionDb()
    {
        $filename = \Yii::getAlias('@backups/' . date('Ymd') . '/' . date('His') . '_db.sql');
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
    public function actionImages()
    {
        $destination = \Yii::getAlias('@backups/' . date('Ymd') . '/' . date('His') . '_images.sql');
        $source = \Yii::getAlias('@images');
        exec(
            "tar -zcvf \"{$destination}\" \"{$source}\"",
            $output
        );
        if ($output == '') {
            /* no output is good */
            echo $destination;
        } else {
            /* we have something to log the output here*/
            echo $output;
        }
    }
}