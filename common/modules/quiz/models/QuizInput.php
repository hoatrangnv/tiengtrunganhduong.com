<?php

namespace common\modules\quiz\models;

use Yii;
use yii\helpers\ArrayHelper;

class QuizInput extends \common\modules\quiz\baseModels\QuizInput
{
    public static function modelConfig()
    {
        $modelConfig = parent::modelConfig();

        $modelConfig['attrs'][] = [
            'type' => 'MultipleSelect',
            'name' => 'quiz_input_validator_ids',
            'label' => 'Quiz input validators',
            'value' => [],
            'errorMsg' => '',
            'options' => '@list QuizInputValidator',
            'rules' => [],
        ];

        foreach ($modelConfig['attrs'] as &$attr) {
            $newAttr = $attr;
            if ($newAttr['name'] === 'type') {
                $newAttr['type'] = 'Select';
                $newAttr['options'] = [
                    'RadioGroup',
                    'CheckboxGroup',
                    'Checkbox',
                    'Select',
                    'Text',
                    'Number',
                    'Datetime',
                    'Date',
                    'WordGuessing',
                ];
            }
            $attr = $newAttr;
        }

        return $modelConfig;
    }
}
