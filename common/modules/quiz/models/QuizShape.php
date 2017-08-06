<?php

namespace common\modules\quiz\models;

use Yii;

class QuizShape extends \common\modules\quiz\baseModels\QuizShape
{
    public static function modelConfig()
    {
        $modelConfig = parent::modelConfig();

        foreach ($modelConfig['attrs'] as &$attr) {
            if ($attr['name'] == 'text') {
                $attr['type'] = 'TextArea';
            }
        }

        $modelConfig['attrs'][] = [
            'type' => 'MultipleSelect',
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
