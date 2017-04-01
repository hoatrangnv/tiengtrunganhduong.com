<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 3/31/2017
 * Time: 12:26 AM
 */

namespace common\models;

use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class MyActiveRecord extends ActiveRecord
{
    public static function castToArray($input) {
        if (!is_array($input)) {
            if ($input && is_string($input)) {
                $input = implode(',', $input);
            } else {
                $input = [];
            }
        }
        return $input;
    }

    public function castValueToArray($attribute)
    {
        $this->$attribute = self::castToArray($this->$attribute);
    }

    public static function find()
    {
        return new MyActiveQuery(get_called_class());
    }

    public function getAllChildren()
    {
        $allChildren = $this->children;
        foreach ($allChildren as $item) {
            $allChildren = array_merge($allChildren, $item->allChildren);
        }
        $query = static::find();
        $query->where(['in', 'id', \yii\helpers\ArrayHelper::getColumn($allChildren, 'id')]);
        $query->multiple = true;
        return $query;
    }

    public static function listAsId2Name()
    {
        return ArrayHelper::map(self::find()->all(), 'id', 'name');
    }
}