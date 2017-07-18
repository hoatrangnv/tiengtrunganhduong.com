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
use common\modules\quiz\models\QuizShape;
use common\modules\quiz\models\QuizSorter;
use common\modules\quiz\models\QuizStyle;
use common\modules\quiz\models\QuizValidator;
use yii\db\ActiveRecord;
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
                $childData['id'] = '__' . rand(1, 99999999);
                if (0 == $i) {
                    $childrenData['activeItemId'] = $childData['id'];
                }
                /**
                 * @var $class QuizBase
                 */
                $class = get_class($child);
                $type = $childData['type'] = join('', array_slice(explode('\\', $class), -1));
                $childAttrs = [];
                $modelConfig = $class::modelConfig();
                foreach ($modelConfig['attrs'] as $attr) {
                    $attr['value'] = $child->getAttribute($attr['name']);
                    $attr['errorMsg'] = '';
                    $childAttrs[] = $attr;
                }
                $childData['attrs'] = $childAttrs;
                $grandChildren = [];
                switch ($type) {
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
        /**
         * @param $data
         * @param $parent QuizBase
         * @param $test
         */
        $loadModels = function (&$data, $parent, $test) use ($parseAttrs, $testingId, &$loadModels, &$errors, &$global_exec_order) {
            $oldChildren = [];
            if (!$parent->isNewRecord) {
                if ($parent instanceof Quiz) {
                    $quiz = $parent;
                    $quizCharacters = $quiz->quizCharacters;
                    $quizParams = $quiz->quizParams;
                    $quizInputGroups = $quiz->quizInputGroups;
                    $quizResults = $quiz->quizResults;
                    $quizShapes = $quiz->quizShapes;
                    $quizStyles = $quiz->quizStyles;
                    $quizValidators = $quiz->quizValidators;
                    $quizFilters = $quiz->quizFilters;
                    $quizSorters = $quiz->quizSorters;
                    $oldChildren = array_merge(
                        $quizInputGroups, $quizCharacters, $quizParams,
                        $quizShapes, $quizResults, $quizSorters, $quizValidators,
                        $quizStyles, $quizFilters
                    );
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
                    for ($i = 0; $i < count($oldChildren); $i++) {
                        if (isset($oldChildren[$i])) {

                            $oldChild = $oldChildren[$i];
                            if ($childData['type'] == join('', array_slice(explode('\\', get_class($oldChild)), -1)) && $attrs['id'] == $oldChild->id) {
                                unset($oldChildren[$i]);
                            }
                        }
                    }
                }
            }
            if (!$test) {
                foreach ($oldChildren as $oldChild) {
                    $oldChild->delete();
                }
            }

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
//                switch ($childData['type']) {
//                    case 'QuizResult':
//                        $model = new QuizResult();
//                        break;
//                    case 'QuizCharacter':
//                        $model = new QuizCharacter();
//                        break;
//                    case 'QuizCharacterMedium':
//                        $model = new QuizCharacterMedium();
//                        break;
//                    case 'QuizInputGroup':
//                        $model = new QuizInputGroup();
//                        break;
//                    case 'QuizInput':
//                        $model = new QuizInput();
//                        break;
//                    case 'QuizInputOption':
//                        $model = new QuizInputOption();
//                        break;
//                    case 'QuizShape':
//                        $model = new QuizShape();
//                        break;
//                    case 'QuizFilter':
//                        $model = new QuizFilter();
//                        break;
//                    case 'QuizSorter':
//                        $model = new QuizSorter();
//                        break;
//                    case 'QuizStyle':
//                        $model = new QuizStyle();
//                        break;
//                    case 'QuizValidator':
//                        $model = new QuizValidator();
//                        break;
//                }
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
                }
            }
        };
        if (!$quiz->id) {
            $quiz->id = $testingId();
        }
        $loadModels($state['childrenData'], $quiz, true);
        if (empty($errors)) {
            if ($quiz->save()) {
                $loadModels($state['childrenData'], $quiz, false);
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
