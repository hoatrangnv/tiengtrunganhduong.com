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
            switch ($newAttr['name']) {
                case 'type':
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
                    $newAttr['defaultValue'] = 'Default';
                    break;
                case 'name':
                    $newAttr['defaultValue'] = 'Result @i{QuizResult}';
                    break;
                case 'canvas_width':
                    $newAttr['defaultValue'] = 600;
                    break;
                case 'canvas_height':
                    $newAttr['defaultValue'] = 315;
                    break;
                case 'canvas_background_color':
                    $newAttr['defaultValue'] = 'gray';
                    break;
            }
            $attr = $newAttr;
        }

        $modelConfig['attrs'][] = [
            'type' => 'CheckboxGroup',
            'name' => 'quiz_shape_ids',
            'label' => 'Quiz shapes',
            'value' => [],
            'errorMsg' => '',
            'options' => '@list QuizShape',
            'rules' => [],
        ];

        $modelConfig['attrs'][] = [
            'type' => 'CheckboxGroup',
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
