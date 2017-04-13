<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 3/31/2017
 * Time: 12:26 AM
 */

namespace common\models;

use Prophecy\Exception\Doubler\MethodNotFoundException;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

abstract class MyActiveRecord extends ActiveRecord implements iMyActiveRecord
{
    public function a($text = null, $options = [], $params = [])
    {
        if (!$text) {
            if ($this->hasAttribute('name')) {
                $text = $this->name;
            } else if ($this->hasAttribute('title')) {
                $text = $this->title;
            } else if ($this->hasAttribute('caption')) {
                $text = $this->caption;
            } else {
                $text = '';
            }
        }
        return Html::a($text, $this->getUrl($params), $options);
    }

    private $_img_srcs = null;

    private $_img_sizes = null;

    public function getImgSrc($size)
    {
        // Initialize
        if (is_null($this->_img_srcs)) {
            $this->_img_srcs = [];
            $this->_img_sizes = [];
            if ($this instanceof Image) {
                $image = $this;
            } else {
                $image = $this->getImage()->oneActive();
            }
            if ($image) {
                $this->_img_srcs[Image::SIZE_0] = $image->getSource();
                $img_sizes = json_decode($image->resize_labels, true);

                if (is_array($img_sizes)) {
                    ksort($img_sizes);
                    foreach ($img_sizes as $key => $label) {
                        $this->_img_srcs[$key] = $image->getSource($label);
                    }
                    $this->_img_sizes = $img_sizes;
                }
            }
        }

        // Get image src by size key or size
        $size_key = Image::getSizeKeyBySize($size, $this->_img_sizes);
        foreach ($this->_img_srcs as $key => $img_src) {
            if ($key >= $size_key) {
                return $this->_img_srcs[$key];
            }
        }
        return isset($this->_img_srcs[Image::SIZE_0]) ? $this->_img_srcs[Image::SIZE_0] : '';
    }

    public function img($size = null, array $options = [])
    {
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
        return Html::img($this->getImgSrc($size), $options);
    }

    public function getContentWithTemplates($attribute = 'content')
    {
        if (!$this->hasAttribute($attribute)) {
            return '';
        }
        return Image::textWithTemplates2Html($this->$attribute);
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
        if ($this->hasMethod('getChildren')) {
            $allChildren = $this->getChildren();
            foreach ($allChildren as $item) {
                $allChildren = array_merge($allChildren, $item->getAllChildren());
            }
            $query = static::find();
            $query->where(['in', 'id', ArrayHelper::getColumn($allChildren, 'id')]);
            $query->multiple = true;
            return $query;
        }
        throw new MethodNotFoundException('Method getChildren not found.', self::className(), null);
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