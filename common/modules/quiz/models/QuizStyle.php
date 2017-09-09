<?php

namespace common\modules\quiz\models;

use Yii;

class QuizStyle extends \common\modules\quiz\baseModels\QuizStyle
{
    public static function modelConfig()
    {
        $modelConfig = parent::modelConfig();

        foreach ($modelConfig['attrs'] as &$attr) {
            switch ($attr['name']) {
                case 'z_index':
                    $attr['placeholder'] = '6 --- the stack order of the layer';
                    break;

            }
        }

        return $modelConfig;
    }
}
