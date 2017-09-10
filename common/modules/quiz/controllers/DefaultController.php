<?php

namespace common\modules\quiz\controllers;

use common\modules\image\models\Image;
use common\modules\quiz\baseModels\QuizBase;
use common\modules\quiz\models\Quiz;
use common\modules\quiz\models\QuizAlert;
use common\modules\quiz\models\QuizCharacter;
use common\modules\quiz\models\QuizCharacterDataFilter;
use common\modules\quiz\models\QuizCharacterDataSorter;
use common\modules\quiz\models\QuizCharacterMedium;
use common\modules\quiz\models\QuizCharacterMediumDataFilter;
use common\modules\quiz\models\QuizCharacterMediumDataSorter;
use common\modules\quiz\models\QuizCharacterMediumToStyle;
use common\modules\quiz\models\QuizInput;
use common\modules\quiz\models\QuizInputGroup;
use common\modules\quiz\models\QuizInputImage;
use common\modules\quiz\models\QuizInputOption;
use common\modules\quiz\models\QuizInputOptionChecker;
use common\modules\quiz\models\QuizObjectFilter;
use common\modules\quiz\models\QuizParam;
use common\modules\quiz\models\QuizResult;
use common\modules\quiz\models\QuizResultToCharacterMedium;
use common\modules\quiz\models\QuizResultToShape;
use common\modules\quiz\models\QuizShape;
use common\modules\quiz\models\QuizShapeToStyle;
use common\modules\quiz\models\QuizStyle;
use common\modules\quiz\models\QuizInputValidator;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Default controller for the `quiz` module
 */
class DefaultController extends BaseController
{
//    public $layout = '@common/modules/quiz/views/layouts/main';
    public $layout = '@common/modules/quiz/views/layouts/antd';

    private static $argsSeparator = "\n";

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        var_dump(QuizCharacter::getTableSchema()->columns);
        return $this->render('index');
    }

    public function actionCreate()
    {
        $inputGroupConfig = QuizInputGroup::modelConfig();
        $inputConfig = QuizInput::modelConfig();
        $inputOptionConfig = QuizInputOption::modelConfig();
        $inputOptionConfig['childConfigs'] = [
            QuizInputOptionChecker::modelConfig(),
        ];
        $inputConfig['childConfigs'] = [
            $inputOptionConfig,
            QuizInputImage::modelConfig(),
        ];
        $inputGroupConfig['childConfigs'] = [$inputConfig];

        $characterConfig = QuizCharacter::modelConfig();
        $characterMediumConfig = QuizCharacterMedium::modelConfig();
        $characterMediumConfig['childConfigs'] = [
            QuizCharacterMediumDataFilter::modelConfig(),
            QuizCharacterMediumDataSorter::modelConfig(),
        ];
        $characterConfig['childConfigs'] = [
            $characterMediumConfig,
            QuizCharacterDataFilter::modelConfig(),
            QuizCharacterDataSorter::modelConfig(),
        ];

        $modelConfigs = [
            $characterConfig,
            $inputGroupConfig,
            QuizAlert::modelConfig(),
            QuizShape::modelConfig(),
            QuizResult::modelConfig(),
            QuizStyle::modelConfig(),
            QuizParam::modelConfig(),
            QuizObjectFilter::modelConfig(),
            QuizInputValidator::modelConfig(),
        ];

        $quizConfig = Quiz::modelConfig();

        return $this->render('editor', [
            'type' => $quizConfig['type'],
            'attrs' => $quizConfig['attrs'],
            'childConfigs' => $modelConfigs,
            'childrenData' => ['items' => [], 'activeItemId' => null, 'errorItemIds' => []],
        ]);
    }

    public function actionUpdate($id)
    {
        $quiz = Quiz::findOne($id);
        if (!$quiz) {
            throw new NotFoundHttpException();
        }
        $quizCharacters = $quiz->quizCharacters;
        $quizParams = $quiz->quizParams;
        $quizInputGroups = $quiz->quizInputGroups;
        $quizResults = $quiz->quizResults;
        $quizShapes = $quiz->quizShapes;
        $quizStyles = $quiz->quizStyles;
        $quizInputValidators = $quiz->quizInputValidators;
        $quizObjectFilters = $quiz->quizObjectFilters;
        $quizAlerts = $quiz->quizAlerts;

        $inputGroupConfig = QuizInputGroup::modelConfig();
        $inputConfig = QuizInput::modelConfig();
        $inputOptionConfig = QuizInputOption::modelConfig();
        $inputOptionConfig['childConfigs'] = [
            QuizInputOptionChecker::modelConfig(),
        ];
        $inputConfig['childConfigs'] = [
            $inputOptionConfig,
            QuizInputImage::modelConfig(),
        ];
        $inputGroupConfig['childConfigs'] = [$inputConfig];

        $characterConfig = QuizCharacter::modelConfig();
        $characterMediumConfig = QuizCharacterMedium::modelConfig();
        $characterMediumConfig['childConfigs'] = [
            QuizCharacterMediumDataFilter::modelConfig(),
            QuizCharacterMediumDataSorter::modelConfig(),
        ];
        $characterConfig['childConfigs'] = [
            $characterMediumConfig,
            QuizCharacterDataFilter::modelConfig(),
            QuizCharacterDataSorter::modelConfig(),
        ];

        $modelConfigs = [
            $characterConfig,
            $inputGroupConfig,
            QuizAlert::modelConfig(),
            QuizShape::modelConfig(),
            QuizResult::modelConfig(),
            QuizStyle::modelConfig(),
            QuizParam::modelConfig(),
            QuizObjectFilter::modelConfig(),
            QuizInputValidator::modelConfig(),
        ];

        $quizConfig = Quiz::modelConfig();

        $attrs = [];
        foreach ($quizConfig['attrs'] as $attr) {
            if ($attr['name'] == 'showed_stopwatches') {
                $attr['value'] = json_decode($quiz->getAttribute($attr['name']));
            } else {
                $attr['value'] = $quiz->getAttribute($attr['name']);
            }
            $attrs[] = $attr;
        }

        $children = array_merge(
            $quizInputGroups, $quizCharacters, $quizParams,
            $quizShapes, $quizResults, $quizInputValidators,
            $quizStyles, $quizObjectFilters, $quizAlerts
        );
        /**
         * @param array $children
         * @return array
         */
        $getChildrenData = function (array $children) use (&$getChildrenData, $inputGroupConfig, $inputConfig, $inputOptionConfig, $characterConfig, $characterMediumConfig) {
            $childrenData = ['items' => [], 'activeItemId' => null, 'errorItemIds' => []];
            usort($children, function ($a, $b) {
                /**
                 * @var $a QuizCharacter|QuizParam|QuizCharacterMedium|QuizInputGroup|...
                 * @var $b QuizCharacter|QuizParam|QuizCharacterMedium|QuizInputGroup|...
                 */
                if ($a->hasAttribute('task_order') && $b->hasAttribute('task_order')) {
                    return $a->task_order - $b->task_order;
                }
                if ($a->hasAttribute('task_order')) {
                    return -1;
                }
                if ($b->hasAttribute('task_order')) {
                    return 1;
                }
                /**
                 * @var $a QuizInput|QuizInputOption|...
                 * @var $b QuizInput|QuizInputOption|...
                 */
                if ($a->hasAttribute('sort_order') && $b->hasAttribute('sort_order')) {
                    return $a->sort_order - $b->sort_order;
                }
                if ($a->hasAttribute('sort_order')) {
                    return -1;
                }
                if ($b->hasAttribute('sort_order')) {
                    return 1;
                }
                
                return 0;
            });

            /**
             * @var QuizBase[] $children
             */
            foreach ($children as $i => $child) {
                $childData = [];
                /**
                 * @var $class QuizBase
                 */
                $class = get_class($child);
                $type = $childData['type'] = join('', array_slice(explode('\\', $class), -1));
                $class = "common\modules\quiz\models\\$type";
                $childAttrs = [];
                $modelConfig = $class::modelConfig();
                foreach ($modelConfig['attrs'] as $attr) {
                    $attr['value'] = $child->getAttribute($attr['name']);
                    if ($attr['name'] == 'image_id') {
                        $image = Image::findOne($attr['value']);
                        if ($image) {
                            $attr['options'] = [[
                                'value' => $image->id,
                                'image' => [
                                    'name' => $image->name,
                                    'source' => $image->getSource(),
                                    'width' => $image->width,
                                    'height' => $image->height,
                                    'aspect_ratio' => $image->aspect_ratio,
                                ]
                            ]];
                        }
                    } else if ($attr['name'] == 'arguments') {
                        $arr_value = json_decode($attr['value']);
                        $attr['value'] = implode(self::$argsSeparator, $arr_value);

//                        if (!is_array($attr['value'])) {
//                            $attr['value'] = json_decode($attr['value']);
//                        }
                    }
                    $childAttrs[] = $attr;
                    if ($attr['name'] == 'id') {
                        $childData['id'] = "__$type#{$attr['value']}";
                    }
                }
                $childData['attrs'] = $childAttrs;
                if (0 == $i) {
                    $childrenData['activeItemId'] = $childData['id'];
                }
                $grandChildren = [];
                switch ($type) {
                    case 'QuizResult':
                        /**
                         * @var $child QuizResult
                         */
                        foreach ($childData['attrs'] as &$attr) {
                            switch ($attr['name']) {
                                case 'quiz_character_medium_ids':
                                    $attr['value'] = array_map(function ($id) {
                                        return "__QuizCharacterMedium#$id";
                                    }, ArrayHelper::getColumn($child->quizCharacterMedia, 'id'));
                                    break;
                                case 'quiz_shape_ids':
                                    $attr['value'] = array_map(function ($id) {
                                        return "__QuizShape#$id";
                                    }, ArrayHelper::getColumn($child->quizShapes, 'id'));
                                    break;
//                                case 'quiz_character_medium_filter_ids':
//                                    $attr['value'] = array_map(function ($id) {
//                                        return "__QuizFilter#$id";
//                                    }, ArrayHelper::getColumn($child->quizCharacterMediumFilters, 'id'));
//                                    break;
//                                case 'quiz_shape_filter_ids':
//                                    $attr['value'] = array_map(function ($id) {
//                                        return "__QuizFilter#$id";
//                                    }, ArrayHelper::getColumn($child->quizShapeFilters, 'id'));
//                                    break;

                            }
                        }
                        unset($attr);
                        break;
                    case 'QuizCharacter':
                        /**
                         * @var $child QuizCharacter
                         */
//                        foreach ($childData['attrs'] as &$attr) {
//                            switch ($attr['name']) {
//                                case 'quiz_filter_ids':
//                                    $attr['value'] = array_map(function ($id) {
//                                        return "__QuizFilter#$id";
//                                    }, ArrayHelper::getColumn($child->quizFilters, 'id'));
//                                    break;
//                                case 'quiz_sorter_ids':
//                                    $attr['value'] = array_map(function ($id) {
//                                        return "__QuizSorter#$id";
//                                    }, ArrayHelper::getColumn($child->quizSorters, 'id'));
//                                    break;
//
//                            }
//                        }
//                        unset($attr);
                        $childData['childConfigs'] = $characterConfig['childConfigs'];
                        $grandChildren = array_merge(
                            $child->quizCharacterMedia,
                            $child->quizCharacterDataFilters,
                            $child->quizCharacterDataSorters
                        );
                        break;

                    case 'QuizCharacterMedium':
                        /**
                         * @var $child QuizCharacterMedium
                         */
                        foreach ($childData['attrs'] as &$attr) {
                            switch ($attr['name']) {
//                                case 'quiz_filter_ids':
//                                    $attr['value'] = array_map(function ($id) {
//                                        return "__QuizFilter#$id";
//                                    }, ArrayHelper::getColumn($child->quizFilters, 'id'));
//                                    break;
//                                case 'quiz_sorter_ids':
//                                    $attr['value'] = array_map(function ($id) {
//                                        return "__QuizSorter#$id";
//                                    }, ArrayHelper::getColumn($child->quizSorters, 'id'));
//                                    break;
                                case 'quiz_style_ids':
                                    $attr['value'] = array_map(function ($id) {
                                        return "__QuizStyle#$id";
                                    }, ArrayHelper::getColumn($child->quizStyles, 'id'));
                                    break;

                            }
                        }
                        unset($attr);
                        $childData['childConfigs'] = $characterMediumConfig['childConfigs'];
                        $grandChildren = array_merge(
                            $child->quizCharacterMediumDataFilters,
                            $child->quizCharacterMediumDataSorters
                        );
                        break;

                    case 'QuizInputGroup':
                        /**
                         * @var $child QuizInputGroup
                         */
//                        foreach ($childData['attrs'] as &$attr) {
//                            switch ($attr['name']) {
//                                case 'quiz_input_filter_ids':
//                                    $attr['value'] = array_map(function ($id) {
//                                        return "__QuizFilter#$id";
//                                    }, ArrayHelper::getColumn($child->quizInputFilters, 'id'));
//                                    break;
//                            }
//                        }
//                        unset($attr);
                        $childData['childConfigs'] = $inputGroupConfig['childConfigs'];
                        $grandChildren = $child->quizInputs;
                        break;
                    case 'QuizInput':
                        /**
                         * @var $child QuizInput
                         */
                        foreach ($childData['attrs'] as &$attr) {
                            switch ($attr['name']) {
//                                case 'quiz_input_option_filter_ids':
//                                    $attr['value'] = array_map(function ($id) {
//                                        return "__QuizFilter#$id";
//                                    }, ArrayHelper::getColumn($child->quizInputOptionFilters, 'id'));
//                                    break;
                                case 'quiz_input_validator_ids':
                                    $attr['value'] = array_map(function ($id) {
                                        return "__QuizInputValidator#$id";
                                    }, ArrayHelper::getColumn($child->quizInputValidators, 'id'));
                                    break;

                            }
                        }
                        unset($attr);
                        $childData['childConfigs'] = $inputConfig['childConfigs'];
                        $grandChildren = array_merge(
                            $child->quizInputOptions,
                            $child->quizInputImages
                        );
                        break;
                    case 'QuizInputOption':
                        /**
                         * @var $child QuizInputOption
                         */
                        foreach ($childData['attrs'] as &$attr) {
                            switch ($attr['name']) {
                                case 'quiz_voted_result_ids':
                                    $attr['value'] = array_map(function ($id) {
                                        return "__QuizResult#$id";
                                    }, ArrayHelper::getColumn($child->quizVotedResults, 'id'));
                                    break;

                            }
                        }
                        unset($attr);
                        $childData['childConfigs'] = $inputOptionConfig['childConfigs'];
                        $grandChildren = $child->quizInputOptionCheckers;
                        break;
                    case 'QuizShape':
                        /**
                         * @var $child QuizShape
                         */
                        foreach ($childData['attrs'] as &$attr) {
                            switch ($attr['name']) {
                                case 'quiz_style_ids':
                                    $attr['value'] = array_map(function ($id) {
                                        return "__QuizStyle#$id";
                                    }, ArrayHelper::getColumn($child->quizStyles, 'id'));
                                    break;

                            }
                        }
                        unset($attr);
                        break;
                }

                if (!empty($grandChildren)) {
                    $childData['childrenData'] = $getChildrenData($grandChildren);
                } else {
                    $childData['childrenData'] = ['items' => [], 'activeItemId' => null, 'errorItemIds' => []];
                }

                $childrenData['items'][] = $childData;
            }
            return $childrenData;
        };

        foreach ($attrs as &$attr) {
//            switch ($attr['name']) {
//                case 'quiz_input_group_filter_ids':
//                    $attr['value'] = array_map(function ($id)  {
//                        return "__QuizFilter#$id";
//                    }, ArrayHelper::getColumn($quiz->quizInputGroupFilters, 'id'));
//                    break;
//                case 'quiz_character_filter_ids':
//                    $attr['value'] = array_map(function ($id) {
//                        return "__QuizFilter#$id";
//                    }, ArrayHelper::getColumn($quiz->quizCharacterFilters, 'id'));
//                    break;
//                case 'quiz_result_filter_ids':
//                    $attr['value'] = array_map(function ($id) {
//                        return "__QuizFilter#$id";
//                    }, ArrayHelper::getColumn($quiz->quizResultFilters, 'id'));
//                    break;
//            }
            if ($attr['name'] == 'image_id') {
                $image = Image::findOne($attr['value']);
                if ($image) {
                    $attr['options'] = [[
                        'value' => $image->id,
                        'image' => [
                            'name' => $image->name,
                            'source' => $image->getSource(),
                            'width' => $image->width,
                            'height' => $image->height,
                            'aspect_ratio' => $image->aspect_ratio,
                        ]
                    ]];
                }
            }
        }

        unset($attr);

        $childrenData = $getChildrenData($children);

        return $this->render('editor', [
            'type' => $quizConfig['type'],
            'attrs' => $attrs,
            'childConfigs' => $modelConfigs,
            'childrenData' => $childrenData,
        ]);
    }

    public function actionAjaxSave()
    {
        $reload = false;
        $parseAttrs = function ($attrs) {
            $result = [];
//            var_dump($attrs);die;
            foreach ($attrs as $attr) {
                try {
                    switch ($attr['name']) {
                        case 'arguments':
                            $arr_value = array_map(function ($item) {
                                return trim($item);
                            }, explode(self::$argsSeparator, $attr['value']));
                            $result[$attr['name']] = json_encode($arr_value);
                            break;
//                        case 'duration':
//                            var_dump($attr['value']);die;
//                            break;
                        default:
                            $result[$attr['name']] = $attr['value'];
                    }
                } catch (\Exception $e) {
//                    var_dump($attr);
                }
            }
            return $result;
        };
        $state = json_decode(\Yii::$app->request->post('state'), true);
        $attrs = $parseAttrs($state['attrs']);
        $old_slug = null;
        if ($attrs['id']) {
            $quiz = Quiz::findOne($attrs['id']);
            $old_slug = $quiz->slug;
        } else {
            $quiz = new Quiz();
            $reload = true;
        }
        $attrs['showed_stopwatches'] = json_encode($attrs['showed_stopwatches'] ? $attrs['showed_stopwatches'] : []);
        $quiz->setAttributes($attrs);
        $allErrors = [];
        if (!$quiz->validate()) {
            $allErrors['Quiz#'] = $quiz->errors;
            foreach ($quiz->errors as $attrName => $errors) {
                foreach ($state['attrs'] as &$attr) {
                    if ($attrName == $attr['name']) {
                        $attr['errorMsg'] = implode(", ", $errors);
                    }
                }
            }
        }
        $testingId = function () {
            return rand(0, 999999999);
        };
        $task_order = 0;
        $sort_order = 0;
        $junctions = [
//            'Quiz' => [
///*
//                [
//                    '__id' => '',
//                    'id' => null,
//                    'junctions' => [
//                        'quiz_input_group_filter_ids' => [],
//                        'quiz_character_filter_ids' => [],
//                        'quiz_object_filter_ids' => [],
//                    ],
//                ],
//*/
//            ],
            'QuizResult' => [
/*
                [
                    '__id' => '',
                    'id' => null,
                    'junctions' => [
                        'quiz_character_medium_ids' => [],
                        'quiz_shape_ids' => [],
//                        'quiz_character_medium_filter_ids' => [],
//                        'quiz_shape_filter_ids' => [],
                    ],
                ],
*/
            ],
//            'QuizCharacter' => [
///*
//                [
//                    '__id' => '',
//                    'id' => null,
//                    'junctions' => [
//                        'quiz_filter_ids' => [],
//                        'quiz_sorter_ids' => [],
//                    ],
//                ],
//*/
//            ],
            'QuizCharacterMedium' => [
/*
                [
                    '__id' => '',
                    'id' => null,
                    'junctions' => [
                        'quiz_style_ids' => [],
//                        'quiz_filter_ids' => [],
//                        'quiz_sorter_ids' => [],
                    ],
                ],
*/
            ],
            'QuizShape' => [
/*
                [
                    '__id' => '',
                    'id' => null,
                    'junctions' => [
                        'quiz_style_ids' => [],
                    ]
                ],
*/
            ],
//            'QuizInputGroup' => [
///*
//                [
//                    '__id' => '',
//                    'id' => null,
//                    'junctions' => [
//                        'quiz_input_filter_ids' => [],
//                    ]
//                ],
//*/
//            ],
            'QuizInput' => [
/*
                [
                    '__id' => '',
                    'id' => null,
                    'junctions' => [
//                        'quiz_input_option_filter_ids' => [],
                        'quiz_validator_ids' => [],
                    ]
                ],
*/
            ],
            'QuizInputOption' => [
/*
                [
                    '__id' => '',
                    'id' => null,
                    'junctions' => [
                        'quiz_voted_result_ids' => [],
                    ]
                ],
*/
            ],

            'QuizInputValidator' => [

            ],
        ];
        $addJunction = function ($data, $model, $jnc_names) use (&$junctions) {
            $ref_ids = [];
            foreach ($data['attrs'] as $attr) {
                if (in_array($attr['name'], $jnc_names)) {
                    $ref_ids[$attr['name']] = $attr['value'];
                }
            }
//            if ($data['type'] === 'Quiz') {
//                var_dump($data['attrs']);
//                die;
//            }
            $junctions[$data['type']][] = [
                '__id' => $data['id'],
                'id' => $model->id,
                'junctions' => $ref_ids,
            ];
        };
        $quiz_component_types = [
            'QuizResult',
            'QuizAlert',
            'QuizCharacter',
            'QuizCharacterMedium',
            'QuizParam',
            'QuizInputGroup',
            'QuizInput',
            'QuizInputOption',
            'QuizInputOptionChecker',
            'QuizInputImage',
            'QuizShape',
            'QuizObjectFilter',
            'QuizCharacterDataFilter',
            'QuizCharacterDataSorter',
            'QuizCharacterMediumDataFilter',
            'QuizCharacterMediumDataSorter',
            'QuizStyle',
            'QuizInputValidator',
        ];
        /**
         * @param $data
         * @param $parent QuizBase
         * @param $test
         */
        $loadModels = function (&$data, $parent, $test)
            use ($parseAttrs, $testingId, $quiz_component_types, $addJunction,
                &$loadModels, &$allErrors, &$task_order, &$sort_order, &$junctions) {
            // Delete no longer children
            $oldChildren = [];
            if (!$parent->isNewRecord) {
                if ($parent instanceof Quiz) {
                    $oldChildren = array_merge(
                        $parent->quizCharacters,
                        $parent->quizParams,
                        $parent->quizInputGroups,
                        $parent->quizResults,
                        $parent->quizShapes,
                        $parent->quizStyles,
                        $parent->quizInputValidators,
                        $parent->quizObjectFilters,
                        $parent->quizAlerts
                    );
                } else if ($parent instanceof QuizCharacter) {
                    $oldChildren = array_merge(
                        $parent->quizCharacterMedia,
                        $parent->quizCharacterDataFilters,
                        $parent->quizCharacterDataSorters
                    );
                } else if ($parent instanceof QuizCharacterMedium) {
                    $oldChildren = array_merge(
                        $parent->quizCharacterMediumDataFilters,
                        $parent->quizCharacterMediumDataSorters
                    );
                }  else if ($parent instanceof QuizInputGroup) {
                    $oldChildren = $parent->quizInputs;
                } else if ($parent instanceof QuizInput) {
                    $oldChildren = array_merge(
                        $parent->quizInputOptions,
                        $parent->quizInputImages
                    );
                } else if ($parent instanceof QuizInputOption) {
                    $oldChildren = $parent->quizInputOptionCheckers;
                }
            }
            foreach ($data['items'] as $childData) {
                if (in_array($childData['type'], $quiz_component_types)) {
                    $attrs = $parseAttrs($childData['attrs']);
                    foreach ($oldChildren as $key => $oldChild) {
                        $oldChildType = join('', array_slice(explode('\\', get_class($oldChild)), -1));
                        if ($childData['type'] == $oldChildType && $attrs['id'] == $oldChild->id) {
                            unset($oldChildren[$key]);
                        }
                    }
                }
            }
            if (!$test) {
                foreach ($oldChildren as $oldChild) {
                    $oldChild->delete();
                }
            }

            // Save children
            foreach ($data['items'] as &$childData) {
                $model = null;
                $attrs = $parseAttrs($childData['attrs']);
                if (in_array($childData['type'], $quiz_component_types)) {
                    /**
                     * @var $class Quiz|QuizCharacter|QuizCharacterMedium|QuizInputGroup|QuizInput|QuizInputOption
                     * @var $class QuizStyle|QuizShape|QuizCharacterDataSorter|QuizCharacterDataSorter
                     * @var $class QuizObjectFilter|QuizInputValidator|QuizCharacterMediumDataFilter|QuizCharacterMediumDataSorter
                     */
                    $class = "common\\modules\\quiz\\models\\" . $childData['type'];
                    if ($attrs['id']) {
                        $model = $class::findOne($attrs['id']);
                    } else {
                        $model = new $class();
                    }
                }
                if ($model) {
                    if ($test) {
                        $model->scenario = 'test';
                    }
                    $task_order++;
                    $sort_order++;
                    $attrs['task_order'] = $task_order;
                    $attrs['sort_order'] = $sort_order;

                    // Each model can has only one of these attributes:
                    // quiz_id, quiz_character_id, quiz_input_group_id, quiz_input_id
                    $attrs['quiz_id']
                        = $attrs['quiz_character_id']
                        = $attrs['quiz_character_medium_id']
                        = $attrs['quiz_input_group_id']
                        = $attrs['quiz_input_id']
                        = $attrs['quiz_input_option_id']
                        = $parent->id;
                    $model->setAttributes($attrs);
                    if (!$model->validate()) {
                        $task_order--;
                        $sort_order--;
                        $allErrors["{$childData['type']}#{$childData['id']}"] = $model->errors;
                        foreach ($model->errors as $attrName => $errors) {
                            foreach ($childData['attrs'] as &$attr) {
                                if ($attrName == $attr['name']) {
                                    $attr['errorMsg'] = implode(", ", $errors);
                                }
                            }
                        }
                    }
                    if ($test) {
                        $model->id = $testingId();
                    }
                    if ($test || $model->save()) {
                        $loadModels($childData['childrenData'], $model, $test);
                    }

                    // Junctions
                    switch ($childData['type']) {
                        case 'QuizResult':
                            $addJunction($childData, $model, [
                                'quiz_character_medium_ids',
                                'quiz_shape_ids',
//                                'quiz_character_medium_filter_ids',
//                                'quiz_shape_filter_ids',
                            ]);
                            break;
                        case 'QuizCharacterMedium':
                            $addJunction($childData, $model, [
//                                'quiz_filter_ids',
//                                'quiz_sorter_ids',
                                'quiz_style_ids',
                            ]);
                            break;
//                        case 'QuizCharacter':
//                            $addJunction($childData, $model, [
//                                'quiz_filter_ids',
//                                'quiz_sorter_ids',
//                            ]);
//                            break;
                        case 'QuizShape':
                            $addJunction($childData, $model, [
                                'quiz_style_ids',
                            ]);
                            break;
//                        case 'QuizInputGroup':
//                            $addJunction($childData, $model, [
//                                'quiz_input_filter_ids',
//                            ]);
//                            break;
                        case 'QuizInput':
                            $addJunction($childData, $model, [
//                                'quiz_input_option_filter_ids',
                                'quiz_input_validator_ids',
                            ]);
                            break;
                        case 'QuizInputOption':
                            $addJunction($childData, $model, [
                                'quiz_voted_result_ids',
                            ]);
                            break;
                        case 'QuizParam':
//                        case 'QuizFilter':
                        case 'QuizStyle':
                        case 'QuizInputValidator':
//                        case 'QuizSorter':
                            $addJunction($childData, $model, []);
                            break;


                    }
                }
            }
        };
        if ($quiz->isNewRecord) {
            $quiz->id = $testingId();
        }
        $loadModels($state['childrenData'], $quiz, true);
        if (empty($allErrors)) {
            if ($quiz->isNewRecord) {
                $quiz->id = null;
            }
            if ($quiz->save()) {
//                var_dump($quiz->slug);
//                var_dump($old_slug);die;
                if ($old_slug != $quiz->slug) {
                    $reload = true;
                }
//                $addJunction(array_merge($state, ['type' => 'Quiz', 'id' => '__Quiz#' . $quiz->id]), $quiz, [
//                    'quiz_input_group_filter_ids',
//                    'quiz_character_filter_ids',
//                    'quiz_result_filter_ids',
//                ]);
                $loadModels($state['childrenData'], $quiz, false);
//                VarDumper::dump($junctions, 100, true);die;
                /**
                 * @param $item
                 * @param $jnc_attr
                 * @param $jnc_type
                 * @param $class ActiveRecord
                 * @param $pk1
                 * @param $pk2
                 * @param $fields
                 */
                $saveJunctions = function ($item, $jnc_attr, $jnc_type, $class, $pk1, $pk2, array $fields = []) use ($junctions) {
                    $chr_md_ids = [];
                    if (!isset($item['junctions'][$jnc_attr])) {
                        return false;
                    }
                    foreach ($item['junctions'][$jnc_attr] as $character_medium_id) {
                        foreach ($junctions[$jnc_type] as $item2) {
                            if ($character_medium_id == $item2['__id']) {
                                if (!$jnc = $class::findOne([
                                    $pk1 => (int) $item['id'],
                                    $pk2 => (int) $item2['id'],
                                ])) {
                                    /**
                                     * @var $jnc ActiveRecord
                                     */
                                    $jnc = new $class();
                                    $jnc->$pk1 = (int) $item['id'];
                                    $jnc->$pk2 = (int) $item2['id'];
                                    foreach ($fields as $attr => $val) {
                                        $jnc->$attr = $val;
                                    }
                                    $jnc->save();
                                }
                                $chr_md_ids[] = (int) $item2['id'];
                            }
                        }
                    }
                    // Remove no longer junctions
                    foreach (
                        $class::find()
                            ->where([$pk1 => (int) $item['id']])
                            ->andWhere(['not in', $pk2, $chr_md_ids])
                            ->all() as $no_longer_jnc
                    ) {
                        $no_longer_jnc->delete();
                    }
                    return true;
                };
                $style_order = 0;
                $sorter_order = 0;
                foreach ($junctions as $type => $_junctions) {
                    foreach ($_junctions as $item) {
                        switch ($type) {
//                            case 'Quiz':
//                                $saveJunctions(
//                                    $item,
//                                    'quiz_character_filter_ids',
//                                    'QuizFilter',
//                                    '\common\modules\quiz\models\QuizToCharacterFilter',
//                                    'quiz_id',
//                                    'quiz_character_filter_id'
//                                );
//                                $saveJunctions(
//                                    $item,
//                                    'quiz_result_filter_ids',
//                                    'QuizFilter',
//                                    '\common\modules\quiz\models\QuizToResultFilter',
//                                    'quiz_id',
//                                    'quiz_result_filter_id'
//                                );
//                                $saveJunctions(
//                                    $item,
//                                    'quiz_input_group_filter_ids',
//                                    'QuizFilter',
//                                    '\common\modules\quiz\models\QuizToInputGroupFilter',
//                                    'quiz_id',
//                                    'quiz_input_group_filter_id'
//                                );
//
//                                break;
                            case 'QuizResult':
                                // QuizResult - QuizCharacterMedium
                                $saveJunctions(
                                    $item,
                                    'quiz_character_medium_ids',
                                    'QuizCharacterMedium',
                                    '\common\modules\quiz\models\QuizResultToCharacterMedium',
                                    'quiz_result_id',
                                    'quiz_character_medium_id'
                                );
//                                $chr_md_ids = [];
//                                foreach ($item['junctions']['quiz_character_medium_ids'] as $character_medium_id) {
//                                    foreach ($junctions['QuizCharacterMedium'] as $item2) {
//                                        if ($character_medium_id == $item2['__id']) {
//                                            if (!$jnc = QuizResultToCharacterMedium::findOne([
//                                                'quiz_result_id' => (int) $item['id'],
//                                                'quiz_character_medium_id' => (int) $item2['id'],
//                                            ])) {
//                                                $jnc = new QuizResultToCharacterMedium();
//                                                $jnc->quiz_result_id = (int) $item['id'];
//                                                $jnc->quiz_character_medium_id = (int) $item2['id'];
//                                                $jnc->save();
//                                            }
//                                            $chr_md_ids[] = (int) $item2['id'];
//                                        }
//                                    }
//                                }
//                                // Remove no longer junctions
//                                foreach (
//                                    QuizResultToCharacterMedium::find()
//                                    ->where(['quiz_result_id' => (int) $item['id']])
//                                    ->andWhere(['not in', 'quiz_character_medium_id', $chr_md_ids])
//                                    ->all() as $no_longer_jnc
//                                ) {
//                                    $no_longer_jnc->delete();
//                                }

                                // QuizResult - QuizShape
                                $saveJunctions(
                                    $item,
                                    'quiz_shape_ids',
                                    'QuizShape',
                                    '\common\modules\quiz\models\QuizResultToShape',
                                    'quiz_result_id',
                                    'quiz_shape_id'
                                );
//                                $shape_ids = [];
//                                foreach ($item['junctions']['quiz_shape_ids'] as $shape_id) {
//                                    foreach ($junctions['QuizShape'] as $item2) {
//                                        if ($shape_id == $item2['__id']) {
//                                            if (!$jnc = QuizResultToShape::findOne([
//                                                'quiz_result_id' => $item['id'],
//                                                'quiz_shape_id' => $item2['id'],
//                                            ])) {
//                                                $jnc = new QuizResultToShape();
//                                                $jnc->quiz_result_id = $item['id'];
//                                                $jnc->quiz_shape_id = $item2['id'];
//                                                $jnc->save();
//                                            }
//                                            $shape_ids[] = $item2['id'];
//                                        }
//                                    }
//                                }
//                                // Remove no longer junctions
//                                foreach (
//                                    QuizResultToShape::find()
//                                        ->where(['quiz_result_id' => (int) $item['id']])
//                                        ->andWhere(['not in', 'quiz_shape_id', $shape_ids])
//                                        ->all() as $no_longer_jnc
//                                ) {
//                                    $no_longer_jnc->delete();
//                                }

                                // QuizResult - QuizCharacterMediumFilter

//                                $saveJunctions(
//                                    $item,
//                                    'quiz_character_medium_filter_ids',
//                                    'QuizFilter',
//                                    '\common\modules\quiz\models\QuizResultToCharacterMediumFilter',
//                                    'quiz_result_id',
//                                    'quiz_character_medium_filter_id'
//                                );
//
//                                // QuizResult - QuizShapeFilter
//                                $saveJunctions(
//                                    $item,
//                                    'quiz_shape_filter_ids',
//                                    'QuizFilter',
//                                    '\common\modules\quiz\models\QuizResultToShapeFilter',
//                                    'quiz_result_id',
//                                    'quiz_shape_filter_id'
//                                );
                                break;

                            case 'QuizShape':
                                // QuizShape - QuizStyle
                                $saveJunctions(
                                    $item,
                                    'quiz_style_ids',
                                    'QuizStyle',
                                    '\common\modules\quiz\models\QuizShapeToStyle',
                                    'quiz_shape_id',
                                    'quiz_style_id',
                                    ['style_order' => $style_order++]
                                );
                                break;

//                            case 'QuizCharacter':
//                                $saveJunctions(
//                                    $item,
//                                    'quiz_filter_ids',
//                                    'QuizFilter',
//                                    '\common\modules\quiz\models\QuizCharacterToFilter',
//                                    'quiz_character_id',
//                                    'quiz_filter_id'
//                                );
//                                $saveJunctions(
//                                    $item,
//                                    'quiz_sorter_ids',
//                                    'QuizSorter',
//                                    '\common\modules\quiz\models\QuizCharacterToSorter',
//                                    'quiz_character_id',
//                                    'quiz_sorter_id',
//                                    ['sorter_order' => $sorter_order++]
//                                );
//                                break;

                            case 'QuizCharacterMedium':
//                                $saveJunctions(
//                                    $item,
//                                    'quiz_filter_ids',
//                                    'QuizFilter',
//                                    '\common\modules\quiz\models\QuizCharacterMediumToFilter',
//                                    'quiz_character_medium_id',
//                                    'quiz_filter_id'
//                                );
//                                $saveJunctions(
//                                    $item,
//                                    'quiz_sorter_ids',
//                                    'QuizSorter',
//                                    '\common\modules\quiz\models\QuizCharacterMediumToSorter',
//                                    'quiz_character_medium_id',
//                                    'quiz_sorter_id',
//                                    ['sorter_order' => $sorter_order++]
//                                );
                                $saveJunctions(
                                    $item,
                                    'quiz_style_ids',
                                    'QuizStyle',
                                    '\common\modules\quiz\models\QuizCharacterMediumToStyle',
                                    'quiz_character_medium_id',
                                    'quiz_style_id',
                                    ['style_order' => $style_order++]
                                );
                                break;
//                            case 'QuizInputGroup':
//                                $saveJunctions(
//                                    $item,
//                                    'quiz_input_filter_ids',
//                                    'QuizFilter',
//                                    '\common\modules\quiz\models\QuizInputGroupToInputFilter',
//                                    'quiz_input_group_id',
//                                    'quiz_input_filter_id'
//                                );
//                                break;
                            case 'QuizInput':
//                                $saveJunctions(
//                                    $item,
//                                    'quiz_input_option_filter_ids',
//                                    'QuizFilter',
//                                    '\common\modules\quiz\models\QuizInputToInputOptionFilter',
//                                    'quiz_input_id',
//                                    'quiz_input_option_filter_id'
//                                );
                                $saveJunctions(
                                    $item,
                                    'quiz_input_validator_ids',
                                    'QuizInputValidator',
                                    '\common\modules\quiz\models\QuizInputToInputValidator',
                                    'quiz_input_id',
                                    'quiz_input_validator_id'
                                );

                                break;
                            case 'QuizInputOption':
                                $saveJunctions(
                                    $item,
                                    'quiz_voted_result_ids',
                                    'QuizResult',
                                    '\common\modules\quiz\models\QuizInputOptionToVotedResult',
                                    'quiz_input_option_id',
                                    'quiz_voted_result_id',
                                    ['votes' => 1]
                                );
                                break;
                        }
                    }
                }
            }
        }

        $json_res = json_encode([
            'state' => $state,
            'reloadUrl' => $reload ? Url::to(['update', 'id' => $quiz->id]) : null,
            'success' => empty($allErrors),
            'errors' => $allErrors,
            'errorsDumped' => VarDumper::dumpAsString($allErrors),
        ]);

        echo $json_res;

    }
}
