<?php

namespace common\modules\quiz\controllers;

use common\modules\quiz\baseModels\QuizBase;
use common\modules\quiz\models\Quiz;
use common\modules\quiz\models\QuizCharacter;
use common\modules\quiz\models\QuizCharacterMedium;
use common\modules\quiz\models\QuizFilter;
use common\modules\quiz\models\QuizInput;
use common\modules\quiz\models\QuizInputGroup;
use common\modules\quiz\models\QuizInputOption;
use common\modules\quiz\models\QuizParam;
use common\modules\quiz\models\QuizResult;
use common\modules\quiz\models\QuizResultToCharacterMedium;
use common\modules\quiz\models\QuizResultToShape;
use common\modules\quiz\models\QuizShape;
use common\modules\quiz\models\QuizSorter;
use common\modules\quiz\models\QuizStyle;
use common\modules\quiz\models\QuizValidator;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Default controller for the `quiz` module
 */
class DefaultController extends Controller
{
    public $layout = '@quiz/views/layouts/main';

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
        $inputConfig['childConfigs'] = [QuizInputOption::modelConfig()];
        $inputGroupConfig['childConfigs'] = [$inputConfig];

        $characterConfig = QuizCharacter::modelConfig();
        $characterConfig['childConfigs'] = [QuizCharacterMedium::modelConfig()];

        $modelConfigs = [
            $characterConfig,
            $inputGroupConfig,
            QuizShape::modelConfig(),
            QuizResult::modelConfig(),
            QuizStyle::modelConfig(),
            QuizParam::modelConfig(),
            QuizFilter::modelConfig(),
            QuizSorter::modelConfig(),
            QuizValidator::modelConfig(),
        ];

        $quizConfig = Quiz::modelConfig();

        return $this->render('editor', [
            'type' => $quizConfig['type'],
            'attrs' => $quizConfig['attrs'],
            'childConfigs' => $modelConfigs,
            'childrenData' => ['items' => [], 'activeItemId' => null],
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
        $quizValidators = $quiz->quizValidators;
        $quizFilters = $quiz->quizFilters;
        $quizSorters = $quiz->quizSorters;

        $inputGroupConfig = QuizInputGroup::modelConfig();
        $inputConfig = QuizInput::modelConfig();
        $inputConfig['childConfigs'] = [QuizInputOption::modelConfig()];
        $inputGroupConfig['childConfigs'] = [$inputConfig];

        $characterConfig = QuizCharacter::modelConfig();
        $characterConfig['childConfigs'] = [QuizCharacterMedium::modelConfig()];

        $modelConfigs = [
            $characterConfig,
            $inputGroupConfig,
            QuizShape::modelConfig(),
            QuizResult::modelConfig(),
            QuizStyle::modelConfig(),
            QuizParam::modelConfig(),
            QuizFilter::modelConfig(),
            QuizSorter::modelConfig(),
            QuizValidator::modelConfig(),
        ];

        $quizConfig = Quiz::modelConfig();

        $attrs = [];
        foreach ($quizConfig['attrs'] as $attr) {
            $attr['value'] = $quiz->getAttribute($attr['name']);
            $attr['errorMsg'] = '';
            $attrs[] = $attr;
        }

        $children = array_merge(
            $quizInputGroups, $quizCharacters, $quizParams,
            $quizShapes, $quizResults, $quizSorters, $quizValidators,
            $quizStyles, $quizFilters
        );
        /**
         * @param array $children
         * @return array
         */
        $getChildrenData = function (array $children) use (&$getChildrenData) {
            $childrenData = ['items' => [], 'activeItemId' => null];
            usort($children, function ($a, $b) {
                /**
                 * @var $a QuizCharacter|QuizParam|QuizCharacterMedium|QuizInputGroup|...
                 * @var $b QuizCharacter|QuizParam|QuizCharacterMedium|QuizInputGroup|...
                 */
                if ($a->hasAttribute('global_exec_order') && $b->hasAttribute('global_exec_order')) {
                    return $a->global_exec_order - $b->global_exec_order;
                }
                if ($a->hasAttribute('global_exec_order')) {
                    return -1;
                }
                if ($b->hasAttribute('global_exec_order')) {
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
                    $attr['errorMsg'] = '';
                    $childAttrs[] = $attr;
                    if ($attr['name'] == 'id') {
                        $childData['id'] = '__' . $attr['value'];
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
                                        return '__' . $id;
                                    }, ArrayHelper::getColumn($child->quizCharacterMedia, 'id'));
                                    break;
                                case 'quiz_shape_ids':
                                    $attr['value'] = array_map(function ($id) {
                                        return '__' . $id;
                                    }, ArrayHelper::getColumn($child->quizShapes, 'id'));
                                    break;

                            }
                        }
                        break;
                    case 'QuizCharacter':
                        /**
                         * @var $child QuizCharacter
                         */
                        $childData['childConfigs'] = [QuizCharacterMedium::modelConfig()];
                        $grandChildren = $child->quizCharacterMedia;
                        break;
                    case 'QuizInputGroup':
                        /**
                         * @var $child QuizInputGroup
                         */
                        $childData['childConfigs'] = [QuizInput::modelConfig()];
                        $grandChildren = $child->quizInputs;
                        break;
                    case 'QuizInput':
                        /**
                         * @var $child QuizInput
                         */
                        $childData['childConfigs'] = [QuizInputOption::modelConfig()];
                        $grandChildren = $child->quizInputOptions;
                        break;
                }

                if (!empty($grandChildren)) {
                    $childData['childrenData'] = $getChildrenData($grandChildren);
                } else {
                    $childData['childrenData'] = ['items' => [], 'activeItemId' => null];
                }

                $childrenData['items'][] = $childData;
            }
            return $childrenData;
        };

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
        $parseAttrs = function ($attrs) {
            $result = [];
            foreach ($attrs as $attr) {
                $result[$attr['name']] = $attr['value'];
            }
            return $result;
        };
        $state = json_decode(\Yii::$app->request->post('state'), true);
        $attrs = $parseAttrs($state['attrs']);
        if ($attrs['id']) {
            $quiz = Quiz::findOne($attrs['id']);
        } else {
            $quiz = new Quiz();
        }
        $quiz->setAttributes($attrs);
        $errors = [];
        if (!$quiz->validate()) {
            $errors['Quiz#'] = $quiz->errors;
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
        $global_exec_order = 0;
        $junctions = [
            'QuizResult' => [
//                [
//                    '__id' => '',
//                    'id' => null,
//                    'junctions' => [
//                        'quiz_character_medium_ids' => [],
//                        'quiz_shape_ids' => [],
//                    ],
//                ],
            ],
            'QuizCharacterMedium' => [
//                [
//                    '__id' => '',
//                    'id' => null
//                ],
            ],
            'QuizShape' => [
//                [
//                    '__id' => '',
//                    'id' => null
//                ],
            ],
        ];
        /**
         * @param $data
         * @param $parent QuizBase
         * @param $test
         */
        $loadModels = function (&$data, $parent, $test)
            use ($parseAttrs, $testingId, &$loadModels, &$errors, &$global_exec_order, &$junctions) {
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
                        $parent->quizValidators,
                        $parent->quizFilters,
                        $parent->quizSorters
                    );
                } else if ($parent instanceof QuizCharacter) {
                    $oldChildren = $parent->quizCharacterMedia;
                }  else if ($parent instanceof QuizInputGroup) {
                    $oldChildren = $parent->quizInputs;
                } else if ($parent instanceof QuizInput) {
                    $oldChildren = $parent->quizInputOptions;
                }
            }
            foreach ($data['items'] as $childData) {
                if (in_array($childData['type'], [
                    'QuizResult',
                    'QuizCharacter',
                    'QuizCharacterMedium',
                    'QuizParam',
                    'QuizInputGroup',
                    'QuizInput',
                    'QuizInputOption',
                    'QuizShape',
                    'QuizFilter',
                    'QuizSorter',
                    'QuizStyle',
                    'QuizValidator',
                ])) {
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
                if (in_array($childData['type'], [
                    'QuizResult',
                    'QuizCharacter',
                    'QuizCharacterMedium',
                    'QuizParam',
                    'QuizInputGroup',
                    'QuizInput',
                    'QuizInputOption',
                    'QuizShape',
                    'QuizFilter',
                    'QuizSorter',
                    'QuizStyle',
                    'QuizValidator',
                ])) {
                    /**
                     * @var $class Quiz|QuizCharacter|QuizCharacterMedium|QuizInputGroup|QuizInput|QuizInputOption
                     * @var $class QuizStyle|QuizShape|QuizSorter|QuizFilter|QuizValidator
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
                    $global_exec_order++;
                    $attrs['global_exec_order'] = $global_exec_order;
                    $attrs['quiz_id']
                        = $attrs['quiz_character_id']
                        = $attrs['quiz_input_group_id']
                        = $attrs['quiz_input_id']
                        = $parent->id;
                    $model->setAttributes($attrs);
                    if (!$model->validate()) {
                        $global_exec_order--;
                        $errors["{$childData['type']}#{$childData['id']}"] = $model->errors;
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
                            $quiz_character_medium_ids = [];
                            $quiz_shape_ids = [];
                            foreach ($childData['attrs'] as $attr) {
                                if ($attr['name'] === 'quiz_character_medium_ids') {
                                    $quiz_character_medium_ids = $attr['value'];
                                } else if ($attr['name'] === 'quiz_shape_ids') {
                                    $quiz_shape_ids = $attr['value'];
                                }
                            }
                            $junctions['QuizResult'][] = [
                                '__id' => $childData['id'],
                                'id' => $model->id,
                                'junctions' => [
                                    'quiz_character_medium_ids' => $quiz_character_medium_ids,
                                    'quiz_shape_ids' => $quiz_shape_ids,
                                ]
                            ];
                            break;
                        case 'QuizCharacterMedium':
                        case 'QuizShape':
                            $junctions[$childData['type']][] = [
                                '__id' => $childData['id'],
                                'id' => $model->id,
                            ];
                            break;
                        case 'QuizFilter':
                            break;


                    }
                }
            }
        };
        if ($quiz->isNewRecord) {
            $quiz->id = $testingId();
        }
        $loadModels($state['childrenData'], $quiz, true);
        if (empty($errors)) {
            if ($quiz->isNewRecord) {
                $quiz->id = null;
            }
            if ($quiz->save()) {
                $loadModels($state['childrenData'], $quiz, false);
//                VarDumper::dump($junctions, 100, true);die;
                foreach ($junctions as $type => $junction) {
                    if ($type === 'QuizResult') {
                        foreach ($junction as $item) {
                            foreach ($item['junctions']['quiz_character_medium_ids'] as $character_medium_id) {
                                foreach ($junctions['QuizCharacterMedium'] as $item2) {
                                    if ($character_medium_id == $item2['__id']) {
                                        if (!$jnc = QuizResultToCharacterMedium::findOne([
                                            'quiz_result_id' => (int) $item['id'],
                                            'quiz_character_medium_id' => (int) $item2['id'],
                                        ])) {
                                            $jnc = new QuizResultToCharacterMedium();
                                            $jnc->quiz_result_id = (int) $item['id'];
                                            $jnc->quiz_character_medium_id = (int) $item2['id'];
                                            $jnc->save();
                                        }
                                    }
                                }
                            }
                            foreach ($item['junctions']['quiz_shape_ids'] as $shape_id) {
                                foreach ($junctions['QuizShape'] as $item2) {
                                    if ($shape_id == $item2['__id']) {
                                        if (!$jnc = QuizResultToShape::findOne([
                                            'quiz_result_id' => (int) $item['id'],
                                            'quiz_shape_id' => (int) $item2['id'],
                                        ])) {
                                            $jnc = new QuizResultToShape();
                                            $jnc->quiz_result_id = (int) $item['id'];
                                            $jnc->quiz_shape_id = (int) $item2['id'];
                                            $jnc->save();
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        echo json_encode([
            'state' => $state,
            'updateLink' => Url::to(['update', 'id' => $quiz->id]),
            'success' => empty($errors),
        ]);
//    }
//        echo json_encode([
//            'id' => $quiz->id,
//            'errors' => $errors
//        ]);
    }
}
