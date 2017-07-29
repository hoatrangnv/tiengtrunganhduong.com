<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 7/24/2017
 * Time: 11:56 PM
 */

namespace common\modules\quiz\models;


class QuizAlert extends \common\modules\quiz\baseModels\QuizAlert
{
    public static function modelConfig()
    {
        $modelConfig = parent::modelConfig();

        foreach ($modelConfig['attrs'] as &$attr) {
            $newAttr = $attr;
            if ($newAttr['name'] === 'type') {
                $newAttr['type'] = 'Select';
                $newAttr['options'] = [
                    'Info',
                    'Warning',
                    'Danger',
                    'Success',
                    'Primary',
                    'Default',
                ];
            }
            $attr = $newAttr;
        }

        return $modelConfig;
    }
}