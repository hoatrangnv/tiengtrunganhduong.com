<?php
/**
 * Created by PhpStorm.
 * User: Quyet
 * Date: 6/30/2017
 * Time: 10:27 AM
 */

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

class Image extends \common\modules\image\models\Image
{
    /**
     * @return array
     */
    public static function listAsId2Name()
    {
        return ArrayHelper::map(self::find()->all(), 'id', 'name');
    }

    /**
     * @return MyActiveQuery
     */
    public static function find()
    {
        return new MyActiveQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(Article::className(), ['image_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreator()
    {
        return $this->hasOne(User::className(), ['id' => 'creator_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdater()
    {
        return $this->hasOne(User::className(), ['id' => 'updater_id']);
    }

    /**
     * Query Template
     */

    /**
     * @return array
     */
    public function templateMethods()
    {
        return [
            'attribute' => function ($name) {
                return $this->getAttribute($name);
            },
            'imgTag' => function ($size = null, $options = [], $srcOptions = []) {
                if (Yii::$app->controller && in_array(Yii::$app->controllerNamespace, ['backend\\controllers'])
                ) {
                    $srcOptions = array_merge($srcOptions, ['image_id' => $this->id]);
                }
                return $this->img($size, $options, $srcOptions);
            },
            'source' => function ($size = null, $options = []) {
                return $this->getImgSrc($size, $options);
            },
            'filename' => function ($size = null, $options = []) {
                return $this->getImgFileName($size, $options);
            },
        ];
    }

    /**
     * @param $methodName
     * @param $arguments
     * @return mixed
     * @throws \Exception
     */
    public function callTemplateMethod($methodName, $arguments)
    {
        if (method_exists($this, 'templateMethods')) {
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