<?php

namespace common\modules\quiz\models;

use Yii;

class QuizInputGroup extends \common\modules\quiz\baseModels\QuizInputGroup
{
    public static function modelConfig()
    {
        $modelConfig = parent::modelConfig();

//        $modelConfig['attrs'][] = [
//            'type' => 'MultipleSelect',
//            'name' => 'quiz_input_filter_ids',
//            'label' => 'Quiz input filters',
//            'value' => [],
//            'errorMsg' => '',
//            'options' => '@list QuizFilter',
//            'rules' => [],
//        ];

        return $modelConfig;
    }
}
