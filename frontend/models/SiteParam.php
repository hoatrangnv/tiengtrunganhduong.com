<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 6/15/2017
 * Time: 1:53 AM
 */

namespace frontend\models;


class SiteParam extends \common\models\SiteParam
{
    private static $_indexData;

    public static function indexData()
    {
        if (self::$_indexData == null) {
            self::$_indexData = self::find()->indexBy('id')->all();
        }

        return self::$_indexData;
    }

    public static function findOneByName($name)
    {
        $data = self::indexData();
        foreach ($data as $item) {
            if ($item->name == $name) {
                return $item;
            }
        }
        return null;
    }

    public static function findAllByNames($names, $limit = INF)
    {
        $result = [];
        $data = self::indexData();
        $i = 0;
        foreach ($data as $item) {
            if (in_array($item->name, $names)) {
                $result[] = $item;
                $i++;
            }
            if ($i >= $limit) {
                break;
            }
        }
        return $result;
    }

}