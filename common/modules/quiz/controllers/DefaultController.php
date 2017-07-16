<?php

namespace common\modules\quiz\controllers;

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
            'childConfigs' => $modelConfigs
        ]);
    }

    public function actionUpdate()
    {

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
        $quiz = new Quiz();
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
                switch ($childData['type']) {
                    case 'QuizResult':
                        $model = new QuizResult();
                        break;
                    case 'QuizCharacter':
                        $model = new QuizCharacter();
                        break;
                    case 'QuizCharacterMedium':
                        $model = new QuizCharacterMedium();
                        break;
                    case 'QuizInputGroup':
                        $model = new QuizInputGroup();
                        break;
                    case 'QuizInput':
                        $model = new QuizInput();
                        break;
                    case 'QuizInputOption':
                        $model = new QuizInputOption();
                        break;
                    case 'QuizShape':
                        $model = new QuizShape();
                        break;
                    case 'QuizFilter':
                        $model = new QuizFilter();
                        break;
                    case 'QuizSorter':
                        $model = new QuizSorter();
                        break;
                    case 'QuizStyle':
                        $model = new QuizStyle();
                        break;
                    case 'QuizValidator':
                        $model = new QuizValidator();
                        break;
                }
                if ($model) {
                    if ($test) {
                        $model->scenario = 'test';
                    }
                    $global_exec_order++;
                    $attrs['global_exec_order'] = $global_exec_order;
                    $attrs['quiz_id']
                        = $attrs['character_id']
                        = $attrs['input_group_id']
                        = $attrs['input_id']
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
        echo json_encode($errors);
    }
}
