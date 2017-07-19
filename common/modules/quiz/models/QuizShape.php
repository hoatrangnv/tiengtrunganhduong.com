<?php

namespace common\modules\quiz\models;

use Yii;

class QuizShape extends \common\modules\quiz\baseModels\QuizShape
{
    public static function modelConfig()
    {
        $modelConfig = parent::modelConfig();

        $modelConfig['attrs'][] = [
            'type' => 'multipleSelectBox',
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
