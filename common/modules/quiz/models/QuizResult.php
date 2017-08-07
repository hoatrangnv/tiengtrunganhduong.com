<?php

namespace common\modules\quiz\models;

use Yii;

class QuizResult extends \common\modules\quiz\baseModels\QuizResult
{
    public static function modelConfig()
    {
        $modelConfig = parent::modelConfig();

        foreach ($modelConfig['attrs'] as &$attr) {
            $newAttr = $attr;
            if ($newAttr['name'] === 'type') {
                $newAttr['type'] = 'Select';
                $newAttr['options'] = [
                    'Bad',
                    'Good',
                    'Excellent',
                    'Funny',
                    'Sad',
                    'Happy',
                    'Default',
                ];
            }
            $attr = $newAttr;
        }

        $modelConfig['attrs'][] = [
            'type' => 'MultipleSelect',
            'name' => 'quiz_shape_ids',
            'label' => 'Quiz shapes',
            'value' => [],
            'errorMsg' => '',
            'options' => '@list QuizShape',
            'rules' => [],
        ];

        $modelConfig['attrs'][] = [
            'type' => 'MultipleSelect',
            'name' => 'quiz_character_medium_ids',
            'label' => 'Quiz character media',
            'value' => [],
            'errorMsg' => '',
            'options' => '@list QuizCharacterMedium',
            'rules' => [],
        ];

        return $modelConfig;
    }
}
