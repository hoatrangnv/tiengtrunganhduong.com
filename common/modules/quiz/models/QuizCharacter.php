<?php

namespace common\modules\quiz\models;

use Yii;

class QuizCharacter extends \common\modules\quiz\baseModels\QuizCharacter
{
    public static function modelConfig()
    {
        $modelConfig = parent::modelConfig();

        foreach ($modelConfig['attrs'] as &$attr) {
            if ($attr['name'] === 'type') {
                $attr['type'] = 'RadioGroup';
                $attr['options'] = [
                    'Player',
                    'PlayerFriend',
                ];
            }
        }

        return $modelConfig;
    }
}
