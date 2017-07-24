<?php

namespace common\modules\quiz\models;

use Yii;

class QuizInput extends \common\modules\quiz\baseModels\QuizInput
{
    public static function modelConfig()
    {
        $modelConfig = parent::modelConfig();

//        $modelConfig['attrs'][] = [
//            'type' => 'multipleSelectBox',
//            'name' => 'quiz_input_option_filter_ids',
//            'label' => 'Quiz input option filters',
//            'value' => [],
//            'errorMsg' => '',
//            'options' => '@list QuizFilter',
//            'rules' => [],
//        ];

        $modelConfig['attrs'][] = [
            'type' => 'multipleSelectBox',
            'name' => 'quiz_input_validator_ids',
            'label' => 'Quiz input validators',
            'value' => [],
            'errorMsg' => '',
            'options' => '@list QuizInputValidator',
            'rules' => [],
        ];

        return $modelConfig;
    }
}
