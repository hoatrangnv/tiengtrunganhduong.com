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
use yii\helpers\Html;

class MyActiveRecord extends ActiveRecord
{
    private $_imgs = null;
    public function img($size_key = 0, array $options = [])
    {
        // Initialize
        if (is_null($this->_imgs)) {
            $this->_imgs = [];
            if ($image = $this->image) {
                if (!isset($options['alt'])) {
                    if ($this->hasAttribute('name')) {
                        $options['alt'] = $this->name;
                    } else if ($this->hasAttribute('title')) {
                        $options['alt'] = $this->title;
                    } else if ($this->hasAttribute('caption')) {
                        $options['alt'] = $this->caption;
                    } else {
                        $options['alt'] = '';
                    }
                }
                if (!isset($options['title'])) {
                    $options['title'] = $options['alt'];
                }
                $this->_imgs[0] = Html::img($image->getSource(), $options);
                $resize_labels = json_decode($image->resize_labels, true);
                if (is_array($resize_labels)) {
                    ksort($resize_labels);
                    foreach ($resize_labels as $key => $label) {
                        $this->_imgs[$key] = Html::img($image->getSource($label), $options);
                    }
                }
            }
        }

        // Get image by size key
        foreach ($this->_imgs as $key => $img) {
            if ($key >= $size_key) {
                return $this->_imgs[$key];
            }
        }
        return isset($this->_imgs[3]) ? $this->_imgs[3] : '';
    }

    public static function castToArray($input)
    {
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

    public static function find()
    {
        return new MyActiveQuery(get_called_class());
    }
}