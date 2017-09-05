<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 7/15/2017
 * Time: 7:56 AM
 */

namespace common\modules\quiz\baseModels;


use common\db\MyActiveRecord;
use common\modules\gii\generators\model\Generator;
use common\modules\quiz\models\QuizFn;
use yii\db\ActiveRecord;
use yii\db\Schema;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;

class QuizBase extends MyActiveRecord
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
                'quiz_character_id',
                'quiz_character_medium_id',
                'quiz_input_group_id',
                'quiz_input_id',
                'quiz_input_option_id',
                'create_time',
                'update_time',
                'creator_id',
                'updater_id',
                'view_count',
                'comment_count',
                'like_count',
                'share_count',
            ])) {
                continue;
            }

            $type = 'text';
            $options = [];
            if (in_array($column->name, [
                'id',
                'task_order',
                'sort_order',
            ])) {
//                $type = 'Hidden';
                $type = 'None';
            } else if ($column->name === 'arguments') {
                $type = 'TextArea';
            } else if ($column->name === 'image_id') {
                $type = 'ImageSelect';
            } else if (substr($column->name, -5) === '_time') {
                $type = 'Datetime';
            } else if (substr($column->name, -3) === '_id') {
                $type = 'Select';
                if (substr($column->name, -6) === '_fn_id') {
                    $quizFns = self::shortClassName() == 'QuizParam'
                        ? QuizFn::find()->all()
                        : QuizFn::find()->where(['or', ['async' => 0], ['async' => null]])->all();
                    foreach ($quizFns as $fn) {
                        /**
                         * @var $fn QuizFn
                         */
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
                        $type = 'RichText';
                        break;
                    case Schema::TYPE_INTEGER:
                    case Schema::TYPE_FLOAT:
                    case Schema::TYPE_DOUBLE:
                        $type = 'Number';
                        break;
                    case Schema::TYPE_SMALLINT:
                        $type = 'Checkbox';
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
            'type' => self::shortClassName(),
            'attrs' => $inputConfigs
        ];
    }

    public static function shortClassName()
    {
         return join('', array_slice(explode('\\', self::className()), -1));
    }
}