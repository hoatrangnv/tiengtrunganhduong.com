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

        return $this->render('create', [
            'type' => $quizConfig['type'],
            'attrConfigs' => $quizConfig['attrConfigs'],
            'attrsData' => null,
            'childConfigs' => $modelConfigs
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

        $attrsData = [];
        foreach ($quizConfig['attrConfigs'] as $attrConfig) {
            $attrData['config'] = $attrConfig;
            $attrData['name'] = $attrConfig['name'];
            $attrData['value'] = $quiz->getAttribute($attrConfig['name']);
            $attrData['errorMsg'] = '';
            $attrsData[] = $attrData;
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
            $childrenData = [];
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
            foreach ($children as $child) {
                $childData = [];
                $childData['id'] = '__' . rand(1, 99999999);
                /**
                 * @var $class QuizBase
                 */
                $class = get_class($child);
                $type = $childData['type'] = join('', array_slice(explode('\\', $class), -1));
                $childAttrsData = [];
                $modelConfig = $class::modelConfig();
                foreach ($modelConfig['attrConfigs'] as $attrConfig) {
                    $attrData['config'] = $attrConfig;
                    $attrData['name'] = $attrConfig['name'];
                    $attrData['value'] = $child->getAttribute($attrConfig['name']);
                    $attrData['errorMsg'] = '';
                    $childAttrsData[] = $attrData;
                }
                $childData['attrsData'] = $childAttrsData;
                $childData['attrConfigs'] = $modelConfig['attrConfigs'];
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
                    $childData['childrenData'] = [];
                }

                $childrenData[] = $childData;
            }
            return $childrenData;
        };

        $childrenData = $getChildrenData($children);

        return $this->render('create', [
            'type' => $quizConfig['type'],
            'attrConfigs' => $quizConfig['attrConfigs'],
            'attrsData' => $attrsData,
            'childConfigs' => $modelConfigs,
            'childrenData' => $childrenData,
        ]);
    }

    public function actionAjaxCreate()
    {
        $parseAttrs = function ($attrsData) {
            $attrs = [];
            foreach ($attrsData as $attrData) {
                $attrs[$attrData['name']] = $attrData['value'];
            }
            return $attrs;
        };
        $state = json_decode(\Yii::$app->request->post('state'), true);
        $attrs = $parseAttrs($state['attrsData']);
//        echo json_encode($attrs);
        if ($attrs['id']) {
            $quiz = Quiz::findOne($attrs['id']);
        } else {
            $quiz = new Quiz();
        }
        $quiz->setAttributes($attrs);
        $errors = [];
        if (!$quiz->validate()) {
            $errors['Quiz'] = $quiz->errors;
        }
        $testingId = function () {
            return rand(0, 999999999);
        };
        $global_exec_order = 0;
        $loadModels = function ($data, $parent_id, $test) use ($parseAttrs, $testingId, &$loadModels, &$errors, &$global_exec_order) {
            foreach ($data as $childData) {
                $model = null;
                $attrs = $parseAttrs($childData['attrsData']);
                if (in_array($childData['type'], [
                    'QuizResult',
                    'QuizCharacter',
                    'QuizCharacterMedium',
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
                        = $parent_id;
                    $model->setAttributes($attrs);
                    if (!$model->validate()) {
                        $global_exec_order--;
                        $errors["{$childData['type']}#{$childData['id']}"] = $model->errors;
                    }
                    if ($test || $model->save()) {
                        $loadModels($childData['childrenData'], $test ? $testingId() : $model->id, $test);
                    }
                }
            }
        };
        $loadModels($state['childrenData'], $testingId(), true);
        if (empty($errors)) {
            if ($quiz->save()) {
                $loadModels($state['childrenData'], $quiz->id, false);
            }
        }
        echo json_encode([$quiz->id, $errors]);
    }
}
