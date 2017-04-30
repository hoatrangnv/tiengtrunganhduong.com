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
    public function a($text = null, array $options = [], array $urlParams = [])
    {
        if (!$text) {
            if ($this->hasAttribute('name')) {
                $text = $this->getAttribute('name');
            } else if ($this->hasAttribute('title')) {
                $text = $this->getAttribute('title');
            } else if ($this->hasAttribute('caption')) {
                $text = $this->getAttribute('caption');
            } else {
                $text = '';
            }
        }
        return Html::a($text, $this->getUrl($urlParams), $options);
    }

    public function img($size = null, array $options = [], array $srcOptions = [])
    {
        if (!isset($options['alt'])) {
            if ($this->hasAttribute('name')) {
                $options['alt'] = $this->getAttribute('name');
            } else if ($this->hasAttribute('title')) {
                $options['alt'] = $this->getAttribute('title');
            } else if ($this->hasAttribute('caption')) {
                $options['alt'] = $this->getAttribute('caption');
            } else {
                $options['alt'] = '';
            }
        }

        if (!isset($options['title'])) {
            $options['title'] = $options['alt'];
        }

        if ($this instanceof Image) {
            return $this->getImgTag($size, $options, $srcOptions);
        }

        if ($this->hasMethod('getImage') && $image = $this->getImage()->oneActive()) {
            return $image->getImgTag($size, $options, $srcOptions);
        }

        return '';
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

    /**
     * @param $methodName
     * @param $arguments
     * @return mixed
     * @throws \Exception
     */
    public function callTemplateMethod($methodName, $arguments)
    {
        if ($this->hasMethod('templateMethods')) {
            $methods = $this->templateMethods();
        } else {
            throw new \Exception("There is not any template method in \"" . get_class($this) . "\"");
        }
        if (!isset($methods[$methodName])) {
            throw new \Exception("Template method \"$methodName\" does not exist in \"" . get_class($this) . "\"");
        }
        return call_user_func_array($methods[$methodName], $arguments);
    }
}