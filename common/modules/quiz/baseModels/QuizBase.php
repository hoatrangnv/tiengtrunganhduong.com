<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 7/15/2017
 * Time: 7:56 AM
 */

namespace common\modules\quiz\baseModels;


use yii\db\ActiveRecord;

class QuizBase extends ActiveRecord
{
    /**
     * @return array
     */
    public static function modelConfig()
    {
        $inputConfigs = [];
        foreach (self::getTableSchema()->columns as $column) {
            if (in_array($column->name, [
                'id',
                'quiz_id',
                'create_time',
                'update_time',
                'creator_id',
                'updater_id',
                'global_exec_order',
            ])) {
                continue;
            }
            $inputConfig = [
                'type' => $column->type == 'integer' ? 'number' : 'text',
                'name' => $column->name,
                'label' => $column->name,
                'rules' => [
                    'required' => !$column->allowNull,
                ]
            ];
            $inputConfigs[] = $inputConfig;
        }
        return [
            'type' => join('', array_slice(explode('\\', self::className()), -1)),
            'name' => join('', array_slice(explode('\\', self::className()), -1)),
            'inputConfigs' => $inputConfigs,
        ];
    }
}