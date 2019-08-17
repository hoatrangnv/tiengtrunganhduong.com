<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 4/4/2017
 * Time: 12:15 AM
 */

namespace frontend\models;

use \common\models\Image as CommonImage;
use Yii;

class Image extends CommonImage
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

        if (Yii::$app->params['amp']) {
            $tag = parent::img(null, $options, $srcOptions);
            $tag = str_replace('<img', '<amp-img', $tag);
        } else {
            $tag = parent::img($size, $options, $srcOptions);
        }
        return $tag;
    }
}