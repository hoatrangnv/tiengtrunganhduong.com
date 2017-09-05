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
                case 'inputs_appearance':
                    $newAttr['type'] = 'Select';
                    $newAttr['options'] = [
                        [
                            'value' => 'Simultaneously',
                            'label' => 'Đồng thời',
                        ],
                        [
                            'value' => 'InTurn',
                            'label' => 'Lần lượt',
                        ]
                    ];
                    break;
                case 'timeout_handling':
                    $newAttr['type'] = 'Select';
                    $newAttr['options'] = [
                        'IgnoreInputGroup',
                        'ShowResult',
                        'GameOver',
                    ];
                    break;
            }
            $attr = $newAttr;
        }

        return $modelConfig;
    }
}
