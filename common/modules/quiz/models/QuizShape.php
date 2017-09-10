<?php

namespace common\modules\quiz\models;

use Yii;

class QuizShape extends \common\modules\quiz\baseModels\QuizShape
{
    public static function modelConfig()
    {
        $modelConfig = parent::modelConfig();

        foreach ($modelConfig['attrs'] as &$attr) {
            if ($attr['name'] == 'text') {
                $attr['type'] = 'TextArea';
                $attr['placeholder'] =
                    "You can embed data to text:\n"
                    . "{{@r.params.var_name}} => value of param `var_name`\n"
                    . "{{@r.inputs.var_name.value}} => value of input `var_name`\n"
                    . "{{@r.characters.var_name.name}} => name of character `var_name`\n"
                    . "{{@statistics.score}} => current score of all inputs\n"
                    . "{{@elapsedTime.total}}, {{@elapsedTime.allQAs}} and {{@elapsedTime.closedQAs}} => total, all questions answering and closed questions answering elapsed time\n"
                ;
            }
        }

        $modelConfig['attrs'][] = [
            'type' => 'CheckboxGroup',
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
