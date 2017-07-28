<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 7/15/2017
 * Time: 7:56 AM
 */

namespace common\modules\quiz\baseModels;


use common\modules\gii\generators\model\Generator;
use common\modules\quiz\models\QuizFn;
use yii\db\ActiveRecord;
use yii\db\Schema;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;

class QuizBase extends ActiveRecord
{
    /**
     * @return array
     */
    public static function modelConfig()
    {
        $inputConfigs = [];
        $table = self::getTableSchema();
        foreach ($table->columns as $column) {
            if (in_array($column->name, [
                'quiz_id',
                'character_id',
                'input_group_id',
                'input_id',
                'create_time',
                'update_time',
                'creator_id',
                'updater_id',
                'task_order',
            ])) {
                continue;
            }

            $type = 'text';
            $options = [];
            if ($column->name == 'id') {
                $type = 'hidden';
            } else if (substr($column->name, -8) === '_fn_args') {
                $type = 'Text';
            } else if (substr($column->name, -5) === '_time') {
                $type = 'Datetime';
            } else if (substr($column->name, -3) === '_id') {
                $type = 'Select';
                if (substr($column->name, -6) === '_fn_id') {
                    foreach (QuizFn::find()->all() as $fn) {
                        $options[] = [
                            'label' => $fn->name,
                            'value' => $fn->id
                        ];
                    }
                }
            } else {
                switch ($column->type) {
                    case Schema::TYPE_CHAR:
                    case Schema::TYPE_STRING:
                        $type = 'Text';
                        break;
                    case Schema::TYPE_TEXT:
                        $type = 'TextArea';
                        break;
                    case Schema::TYPE_INTEGER:
                    case Schema::TYPE_FLOAT:
                    case Schema::TYPE_DOUBLE:
                        $type = 'Number';
                        break;
                }
            }
            $inputConfig = [
                'type' => $type,
                'name' => $column->name,
                'label' => Inflector::humanize($column->name),
                'value' => '',
                'errorMsg' => '',
                'options' => $options,
                'rules' => [
                    'required' => !$column->allowNull,
                ]
            ];
            $inputConfigs[] = $inputConfig;
        }
        return [
            'type' => join('', array_slice(explode('\\', self::className()), -1)),
            'attrs' => $inputConfigs,
        ];
    }
}