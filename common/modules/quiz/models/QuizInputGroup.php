<?php

namespace common\modules\quiz\models;

use Yii;

class QuizInputGroup extends \common\modules\quiz\baseModels\QuizInputGroup
{
    public static function modelConfig()
    {
        $modelConfig = parent::modelConfig();

        foreach ($modelConfig['attrs'] as &$attr) {
            $newAttr = $attr;
            switch ($newAttr['name']) {
//                case 'inputs_appearance':
//                    $newAttr['type'] = 'RadioGroup';
//                    $newAttr['options'] = [
//                        [
//                            'value' => 'Simultaneously',
//                            'label' => 'Đồng thời',
//                        ],
//                        [
//                            'value' => 'InTurn',
//                            'label' => 'Lần lượt',
//                        ]
//                    ];
//                    $newAttr['defaultValue'] = 'InTurn';
//                    break;
                case 'timeout_handling':
                    $newAttr['type'] = 'RadioGroup';
                    $newAttr['options'] = [
                        'ShowQuizResult',
                        'EndQuiz',
                        'EndCurrentQuizInputGroup',
                    ];
                    break;
                case 'name':
                    $newAttr['defaultValue'] = 'Input Group @i{QuizInputGroup}';
                    break;
            }
            $attr = $newAttr;
        }

        return $modelConfig;
    }
}
