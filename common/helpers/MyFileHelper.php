<?php
/**
 * Created by PhpStorm.
 * User: Quyet
 * Date: 4/1/2017
 * Time: 9:10 AM
 */

namespace common\helpers;


use yii\helpers\FileHelper;

class MyFileHelper extends FileHelper
{
    public static function isEmptyDirectory($dir) {
        if (!is_readable($dir)) return NULL;
        $handle = opendir($dir);
        while (false !== ($entry = readdir($handle))) {
            if ($entry != "." && $entry != "..") {
                return FALSE;
            }
        }
        return TRUE;
    }

    public static function moveFile($from, $to, $ensure_remove_source = false)
    {
        if (is_file($from)) {
            if (copy($from, $to)) {
                unlink($from);
                return true;
            }
            if ($ensure_remove_source) {
                unlink($from);
            }
        }
        return false;
    }

}