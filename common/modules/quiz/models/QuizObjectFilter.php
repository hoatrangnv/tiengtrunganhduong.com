<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 7/24/2017
 * Time: 11:59 PM
 */

namespace common\modules\quiz\models;


class QuizObjectFilter extends \common\modules\quiz\baseModels\QuizObjectFilter
{
    public static function modelConfig()
    {
        $modelConfig = parent::modelConfig();

        foreach ($modelConfig['attrs'] as &$attr) {
            $newAttr = $attr;
            if ($newAttr['name'] === 'affected_object_type') {
                $newAttr['type'] = 'Select';
                $newAttr['options'] = [
                    'QuizAlert',
                    'QuizInputGroup',
                    'QuizCharacter',
                    'QuizParam',
                ];
            }
            $attr = $newAttr;
        }

        return $modelConfig;
    }
}