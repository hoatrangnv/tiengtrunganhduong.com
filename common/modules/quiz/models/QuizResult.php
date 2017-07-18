<?php

namespace common\modules\quiz\models;

use Yii;

class QuizResult extends \common\modules\quiz\baseModels\QuizResult
{
    public static function modelConfig()
    {
        $modelConfig = parent::modelConfig();
        $modelConfig['attrs'][] = [
            'type' => 'multipleSelectBox',
            'name' => 'quiz_shape_ids',
            'label' => 'Quiz shapes',
            'value' => [],
            'errorMsg' => '',
            'options' => '@list QuizShape',
            'rules' => [],
        ];
        $modelConfig['attrs'][] = [
            'type' => 'multipleSelectBox',
            'name' => 'quiz_character_medium_ids',
            'label' => 'Quiz character media',
            'value' => [],
            'errorMsg' => '',
            'options' => '@list QuizCharacterMedium',
            'rules' => [],
        ];
        $modelConfig['attrs'][] = [
            'type' => 'multipleSelectBox',
            'name' => 'quiz_shape_filter_ids',
            'label' => 'Quiz shape filters',
            'value' => [],
            'errorMsg' => '',
            'options' => '@list Filter',
            'rules' => [],
        ];
        $modelConfig['attrs'][] = [
            'type' => 'multipleSelectBox',
            'name' => 'quiz_character_medium_filter_ids',
            'label' => 'Quiz character medium filters',
            'value' => [],
            'errorMsg' => '',
            'options' => '@list Filter',
            'rules' => [],
        ];

        return $modelConfig;
    }
}
