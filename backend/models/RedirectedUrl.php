<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 6/12/2017
 * Time: 2:33 AM
 */

namespace backend\models;


use yii\helpers\Json;

class RedirectedUrl extends \common\models\RedirectedUrl
{
//    public function beforeSave($insert)
//    {
//        if (!$this->isJson()) {
//            $this->from_urls = json_encode(array_map(
//                function ($item) { return trim($item); },
//                explode("\n", str_replace("\r", "", $this->from_urls))
//            ));
//        }
//
//        return parent::beforeSave($insert);
//    }
//
//    public function afterFind()
//    {
//        parent::afterFind();
//
//        if ($this->isJson()) {
//            $from_urls_arr = json_decode($this->from_urls);
//            is_array($from_urls_arr) || $from_urls_arr = [];
//            $this->from_urls = implode("\n", $from_urls_arr);
//        }
//
//    }
//
//    protected function isJson() {
//        json_decode($this->from_urls);
//        return (json_last_error() == JSON_ERROR_NONE);
//    }

}