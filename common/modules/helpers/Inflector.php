<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 6/25/2017
 * Time: 11:05 PM
 */

namespace common\modules\helpers;

class Inflector extends \yii\helpers\Inflector
{
    public static function slug($string, $replacement = '-', $lowercase = true)
    {
        return parent::slug(StringHelper::stripUnicode($string), $replacement, $lowercase);
    }
}