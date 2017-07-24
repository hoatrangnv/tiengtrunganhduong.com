<?php

namespace common\modules\quiz\models;

use Yii;

class QuizCharacterMedium extends \common\modules\quiz\baseModels\QuizCharacterMedium
{
    public static function modelConfig()
    {
        $modelConfig = parent::modelConfig();

        $modelConfig['attrs'][] = [
            'type' => 'multipleSelectBox',
            'name' => 'quiz_filter_ids',
            'label' => 'Quiz filters',
            'value' => [],
            'errorMsg' => '',
            'options' => '@list QuizFilter',
            'rules' => [],
        ];

        $modelConfig['attrs'][] = [
            'type' => 'multipleSelectBox',
            'name' => 'quiz_sorter_ids',
            'label' => 'Quiz sorters',
            'value' => [],
            'errorMsg' => '',
            'options' => '@list QuizSorter',
            'rules' => [],
        ];

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
