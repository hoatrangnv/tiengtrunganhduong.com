<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 9/6/2017
 * Time: 11:26 PM
 */

namespace common\models;

use Yii;
use yii\helpers\Html;

class Audio extends \common\modules\audio\models\Audio
{
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
            'audioTag' => function ($options = []) {
                $src = $this->getSource();
                if (Yii::$app->controller && in_array(Yii::$app->controllerNamespace, ['backend\\controllers'])
                ) {
                    $src .= "?audio_id=$this->id";
                }
                $options['src'] = $src;
                return Html::tag('audio', '', $options);
            },
            'source' => function () {
                return $this->getSource();
            },
        ];
    }
}