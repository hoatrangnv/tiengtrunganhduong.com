<?php

namespace console\controllers;

use yii\console\Controller;
use yii\helpers\FileHelper;

class BackupController extends Controller
{
    public $mysql_pwd;
    public function options($actionID)
    {
        $result = [];
        switch ($actionID) {
            case 'database':
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
    public function actionDatabase()
    {
        $destination = \Yii::getAlias('@backups/') . date('Ymd');
        if (!file_exists($destination)) {
            FileHelper::createDirectory($destination);
        }
        $filename = $destination . '/' . date('His') . '_database.sql';
        exec(
            "mysqldump -P 3306 -h 127.6.245.2 -u adminRxtAczm -p quyettran_com --password=\"{$this->mysql_pwd}\" >$filename",
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
        $destination = \Yii::getAlias('@backups/') . date('Ymd');
        if (!file_exists($destination)) {
            FileHelper::createDirectory($destination);
        }
        $filename = $destination . '/' . date('His') . '_images.tar.gz';
        $source = \Yii::getAlias('@images');
        exec(
            "tar -zcvf -p \"{$filename}\" \"{$source}\"",
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