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
            $output,
            $return
        );
        if (!$return) {
            return $filename;
        } else {
            return $output;
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
        $source_info = pathinfo($source);
        $source_dir = $source_info['dirname'];
        $source_f = $source_info['basename'];
        exec(
            "tar -czf \"{$filename}\" -C \"{$source_dir}\" \"{$source_f}\"",
            $output,
            $return
        );
        if (!$return) {
            return $filename;
        } else {
            return $output;
        }
    }

    public function actionRemoveAll()
    {
        FileHelper::removeDirectory(\Yii::getAlias('@backups'));
    }
}