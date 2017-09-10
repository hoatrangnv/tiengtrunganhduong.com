<?php
/**
 * Created by PhpStorm.
 * User: Quyet
 * Date: 7/12/2017
 * Time: 6:11 PM
 */

namespace common\modules\quiz\models;


class QuizFn extends \common\modules\quiz\baseModels\QuizFn
{
    const RETURN_TYPE_UNDEFINED = 'undefined';
    const RETURN_TYPE_STRING = 'string';
    const RETURN_TYPE_NUMBER = 'number';
    const RETURN_TYPE_BOOLEAN = 'boolean';
    const RETURN_TYPE_OBJECT = 'object';
    const RETURN_TYPE_FUNCTION = 'function';

    public static function returnTypes()
    {
        return [
            self::RETURN_TYPE_UNDEFINED => 'undefined',
            self::RETURN_TYPE_STRING => 'string',
            self::RETURN_TYPE_NUMBER => 'number',
            self::RETURN_TYPE_BOOLEAN => 'boolean',
            self::RETURN_TYPE_OBJECT => 'object',
            self::RETURN_TYPE_FUNCTION => 'function',
        ];
    }
}