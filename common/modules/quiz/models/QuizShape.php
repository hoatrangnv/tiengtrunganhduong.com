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
                    . "@r\n"
                    . "    {{@r.params.var_name}} will be replaced by value of param `var_name`\n"
                    . "    {{@r.inputs.var_name.value}} will be replaced by value of input `var_name`\n"
                    . "    {{@r.characters.var_name.name}} will be replaced by name of character `var_name`\n"
                    . "@statistics\n"
                    . "    {{@statistics.score}} will be replaced by current score of all inputs\n"
                    . "@elapsedTime\n"
                    . "    {{@elapsedTime.total}}, {{@elapsedTime.allQAs}} and {{@elapsedTime.closedQAs}} will be replaced by total, all questions answering and closed questions answering elapsed time\n"
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
