<?php

namespace common\modules\quiz\models;

use Yii;

class QuizInputOption extends \common\modules\quiz\baseModels\QuizInputOption
{
    public static function modelConfig()
    {
        $modelConfig = parent::modelConfig();

        $modelConfig['attrs'][] = [
            'type' => 'MultipleSelect',
            'name' => 'quiz_voted_result_ids',
            'label' => 'Quiz voted results',
            'value' => [],
            'errorMsg' => '',
            'options' => '@list QuizResult',
            'rules' => [],
        ];

        return $modelConfig;
    }
}
