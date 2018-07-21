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

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCreate()
    {
        return $this->render('editor', Quiz::getCreateConfigs());
    }

    public function actionUpdate($id)
    {
        $quiz = Quiz::findOne($id);
        if (!$quiz) {
            throw new NotFoundHttpException();
        }
        return $this->render('editor', $quiz->getUpdateData());
    }

    public function actionAjaxSave()
    {
        return json_encode(Quiz::saveQuizWithState(
            json_decode(\Yii::$app->request->post('state'), true),
            function ($quiz_id) {
                return Url::to(['update', 'id' => $quiz_id]);
            }
        ));

    }
}
