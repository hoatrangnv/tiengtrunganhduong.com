<?php

namespace common\modules\quiz\models;

use Yii;

class QuizCharacter extends \common\modules\quiz\baseModels\QuizCharacter
{
    public static function modelConfig()
    {
        $modelConfig = parent::modelConfig();

//        $modelConfig['attrs'][] = [
//            'type' => 'MultipleSelect',
//            'name' => 'quiz_filter_ids',
//            'label' => 'Quiz filters',
//            'value' => [],
//            'errorMsg' => '',
//            'options' => '@list QuizFilter',
//            'rules' => [],
//        ];
//
//        $modelConfig['attrs'][] = [
//            'type' => 'MultipleSelect',
//            'name' => 'quiz_sorter_ids',
//            'label' => 'Quiz sorters',
//            'value' => [],
//            'errorMsg' => '',
//            'options' => '@list QuizSorter',
//            'rules' => [],
//        ];

        return $modelConfig;
    }
}
