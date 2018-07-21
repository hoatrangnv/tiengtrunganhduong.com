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
                'play_count',
                'exported_play_props',
            ])) {
                continue;
            }
            $type = 'text';
            $placeholder = '';
            $options = [];
            if (in_array($column->name, [
                'id',
                'task_order',
                'sort_order',
                'apply_order',
            ])) {
//                $type = 'Hidden';
                $type = 'None';
            } else if ($column->name == 'image_id') {
                $type = 'ImageSelect';
            } else if (substr($column->name, -5) == '_time') {
                $type = 'Datetime';
            } else if (substr($column->name, -3) == '_id') {
                $type = 'Select';
                if (substr($column->name, -6) == '_fn_id') {
                    $query = QuizFn::find();
                    if (self::shortClassName() != 'QuizParam') {
                        $query = $query->andWhere(['or', ['async' => 0], ['async' => null]]);
                    }
                    switch (self::shortClassName()) {
                        case 'QuizInputValidator':
                        case 'QuizInputOptionChecker':
                        case 'QuizObjectFilter':
                        case 'QuizCharacterDataFilter':
                        case 'QuizCharacterMediumDataFilter':
                            $query->andWhere(['return_type' => QuizFn::RETURN_TYPE_BOOLEAN]);
                            break;
                        case 'QuizCharacterDataSorter':
                        case 'QuizCharacterMediumDataSorter':
                            $query->andWhere(['return_type' => QuizFn::RETURN_TYPE_NUMBER]);
                            break;
                        case 'QuizParam':
                            $query->orderBy('return_type asc, name asc');
                            break;
                    }
                    $quizFns = $query->all();
                    foreach ($quizFns as $fn) {
                        /**
                         * @var $fn QuizFn
                         */
                        $options[] = [
                            'label' => "{{$fn->return_type}} {$fn->name}( {$fn->parameters} )",
                            'value' => $fn->id,
                            'extraInfo' => $fn->guideline
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
                        if (\Yii::$app->request->get('rich_text', 0) == 1) {
                            $type = 'RichText';
                        } else {
                            $type = 'TextArea';
                        }
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

            switch ($column->name) {
                case 'name':
                    $placeholder = 'My Name';
                    break;
                case 'var_name':
                    $placeholder = 'my_name';
                    break;
                case 'countdown_delay':
                    $placeholder = '100 by default, means 100% of second <=> 1 second';
                    break;
                case 'duration':
                    $placeholder = 'seconds';
                    break;
                case 'arguments':
                    $type = 'MonospaceTextArea';
                    switch (self::shortClassName()) {
                        case 'QuizParam':
                            $placeholder = "\"each one on aline\" \n[\"abc\", 123, null] \n@r.characters.var_name.gender \n@r.inputs.var_name.value \n@r.params.var_name \n@statistics.score \n@elapsedTime.closedQAs";
                            break;
                        case 'QuizObjectFilter':
                            $placeholder = "@item.name \n@r.inputs.your_choice.value \n[\"Group 1\", \"Group 3\"] \n\"odd\" \n[\"Group 2\", \"Group 4\"] \n\"even\" \n\"Group 2\" \n2";
                            break;
                        case 'QuizInputValidator':
                            $placeholder = "@value \n@type";
                            break;
                        case 'QuizInputOptionChecker':
                            $placeholder = "@value \n1000";
                            break;
                        case 'QuizCharacterDataSorter':
                        case 'QuizCharacterMediumDataSorter':
                            $placeholder = "@a.birthday \n@b.birthday";
                            break;
                        case 'QuizCharacterDataFilter':
                        case 'QuizCharacterMediumDataFilter':
                            $placeholder = "@item.name \n@index \n@data";
                            break;

                    }
                    break;
            }

            $inputConfig = [
                'type' => $type,
                'name' => $column->name,
                'label' => Inflector::humanize($column->name),
                'placeholder' => $placeholder,
                'readOnly' => false,
                'value' => '',
                'defaultValue' => '',
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