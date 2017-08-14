<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 7/23/2017
 * Time: 3:28 AM
 */

namespace common\modules\quiz\controllers;


use common\modules\quiz\models\QuizAlert;
use common\modules\quiz\models\QuizCharacterDataFilter;
use common\modules\quiz\models\QuizCharacterDataSorter;
use common\modules\quiz\models\QuizCharacter;
use common\modules\quiz\models\QuizCharacterMedium;
use common\modules\quiz\models\QuizCharacterMediumDataFilter;
use common\modules\quiz\models\QuizCharacterMediumDataSorter;
use common\modules\quiz\models\QuizInput;
use common\modules\quiz\models\QuizInputGroup;
use common\modules\quiz\models\QuizInputOption;
use common\modules\quiz\models\QuizInputValidator;
use common\modules\quiz\models\QuizObjectFilter;
use common\modules\quiz\models\QuizParam;
use common\modules\quiz\models\QuizResult;
use common\modules\quiz\models\QuizShape;
use common\modules\quiz\models\QuizStyle;
use yii\web\Controller;
use common\modules\quiz\models\Quiz;
use yii\web\NotFoundHttpException;

class PlayController extends Controller
{
    public $layout = '@quiz/views/layouts/antd';

    public function actionIndex($id)
    {
        $quiz = $this->findModel($id);

        return $this->render('index', $quiz->getPlayData());
    }

    /**
     * Finds the Quiz model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Quiz the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Quiz::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}