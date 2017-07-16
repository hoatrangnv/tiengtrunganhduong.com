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

        $modelConfigs = [
            QuizCharacter::modelConfig(),
            QuizCharacterMedium::modelConfig(),
            QuizShape::modelConfig(),
            QuizResult::modelConfig(),
            QuizStyle::modelConfig(),
            QuizParam::modelConfig(),
            QuizFilter::modelConfig(),
            QuizSorter::modelConfig(),
            QuizValidator::modelConfig(),
            $inputGroupConfig,
        ];

        $quizConfig = Quiz::modelConfig();

        return $this->render('create', [
            'type' => $quizConfig['type'],
            'attrConfigs' => $quizConfig['attrConfigs'],
            'childConfigs' => $modelConfigs
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
        $quiz = new Quiz();
        $quiz->setAttributes($attrs);
        $errors = [];
        if (!$quiz->validate()) {
            $errors['Quiz'] = $quiz->errors;
        }
        $loadModels = function ($data) use ($parseAttrs, &$loadModels, &$errors) {
            foreach ($data as $childData) {
                $model = null;
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
                    $model->setAttributes($parseAttrs($childData['attrsData']));
                    if (!$model->validate()) {
                        $errors["{$childData['type']}#{$childData['id']}"] = $model->errors;
                    }
                }
                $loadModels($childData['childrenData']);
            }
        };
        $loadModels($state['childrenData']);
        echo json_encode($errors);
    }
}
