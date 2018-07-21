<?php

namespace common\modules\quiz\models;

use Yii;

class QuizCharacterMedium extends \common\modules\quiz\baseModels\QuizCharacterMedium
{
    public static function modelConfig()
    {
        $modelConfig = parent::modelConfig();

        foreach ($modelConfig['attrs'] as &$attr) {
            if ($attr['name'] === 'type') {
                $attr['type'] = 'RadioGroup';
                $attr['options'] = [
                    'Avatar',
                    'Photo',
                    'Post',
                ];
            }
        }

        $modelConfig['attrs'][] = [
            'type' => 'CheckboxGroup',
            'name' => 'quiz_style_ids',
            'label' => 'Quiz styles',
            'value' => [],
            'errorMsg' => '',
            'options' => '@list QuizStyle',
            'rules' => [],
        ];

        return $modelConfig;
    }
}
