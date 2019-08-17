<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 6/9/2017
 * Time: 12:49 AM
 */

namespace frontend\models;

use Yii;


class Banner extends \common\models\Banner
{
    public function img($size = null, array $options = [], array $srcOptions = [])
    {
        if (Yii::$app->params['amp']) {
            if (!isset($options['width'])) {
                $options['width'] = 300;
            }
            if (!isset($options['height'])) {
                $options['height'] = 200;
            }
            $options['layout'] = 'responsive';
        }

        if (!isset($options['itemprop'])) {
            $options['itemprop'] = 'image';
        }

        $tag = parent::img($size, $options, $srcOptions);
        if (Yii::$app->params['amp']) {
            $tag = str_replace('<img', '<amp-img', $tag);
        }
        return $tag;
    }
}