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
        $items = \Yii::$app->request->post('items');
        var_dump($items);
    }
}
