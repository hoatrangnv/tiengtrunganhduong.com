<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 7/23/2017
 * Time: 3:28 AM
 */

namespace common\modules\quiz\controllers;


use common\modules\quiz\models\QuizFilter;
use common\modules\quiz\models\QuizCharacter;
use common\modules\quiz\models\QuizInput;
use common\modules\quiz\models\QuizInputGroup;
use common\modules\quiz\models\QuizInputOption;
use common\modules\quiz\models\QuizParam;
use common\modules\quiz\models\QuizSorter;
use yii\web\Controller;
use common\modules\quiz\models\Quiz;
use yii\web\NotFoundHttpException;

class PlayController extends Controller
{
    public function actionIndex($id)
    {
        $quiz = $this->findModel($id);
        $quizCharacters = $quiz->quizCharacters;
        $quizInputGroups = $quiz->quizInputGroups;
        $quizParams = $quiz->quizParams;

        $quizInputGroupFilters = $quiz->quizInputGroupFilters;
        $quizCharacterFilters = $quiz->quizCharacterFilters;
        $quizResultFilters = $quiz->quizResultFilters;

        $_quizInputGroups = array_map(function ($item) {
            /**
             * @var $item QuizInputGroup
             */
            $attrs = $item->attributes;
            $quizInputs = $item->quizInputs;
            $_quizInputs = array_map(function ($item2) {
                /**
                 * @var $item2 QuizInput
                 */
                $attrs2 = $item2->attributes;
                $quizInputOptions = $item2->quizInputOptions;
                $_quizInputOptions = array_map(function ($item3) {
                    /**
                     * @var $item3 QuizInputOption
                     */
                    $attrs3 = $item3->attributes;
                    return $attrs3;
                }, $quizInputOptions);
                $attrs2['quizInputOptions'] = $_quizInputOptions;
                return $attrs2;
            }, $quizInputs);
            $attrs['quizInputs'] = $_quizInputs;
            return $attrs;
        }, $quizInputGroups);

        $_quizCharacters = array_map(function ($item) {
            /**
             * @var $item QuizCharacter
             */
            $attrs = $item->attributes;
            $quizSorters = $item->quizSorters;
            $_quizSorters = array_map(function ($item2) {
                /**
                 * @var $item2 QuizSorter
                 */
                $attrs2 = $item2->attributes;
                $ruleFn = $item2->quizRuleFn;
                $_ruleFn = $ruleFn->attributes;
                $attrs2['ruleFn'] = $_ruleFn;
                return $attrs2;
            }, $quizSorters);
            $quizFilters = $item->quizFilters;
            $_quizFilters = array_map(function ($item2) {
                /**
                 * @var $item2 QuizFilter
                 */
                $attrs2 = $item2->attributes;
                $conditionFn = $item2->quizConditionFn;
                $_conditionFn = $conditionFn->attributes;
                $attrs2['conditionFn'] = $_conditionFn;
                return $attrs2;
            }, $quizFilters);
            $attrs['quizSorters'] = $_quizSorters;
            $attrs['quizFilters'] = $_quizFilters;
            return $attrs;
        }, $quizCharacters);

        $_quizInputGroupFilters = array_map(function ($item) {
            /**
             * @var $item QuizFilter;
             */
            $attrs = $item->attributes;
            $conditionFn = $item->quizConditionFn;
            $_conditionFn = $conditionFn->attributes;
            $attrs['conditionFn'] = $_conditionFn;
            return $attrs;
        }, $quizInputGroupFilters);

        $_quizParams = array_map(function ($item) {
            /**
             * @var $item QuizParam
             */
            $attrs = $item->attributes;
            $valueFn = $item->quizValueFn;
            $_valueFn = $valueFn->attributes;
            $attrs['valueFn'] = $_valueFn;
            return $attrs;
        }, $quizParams);

        return $this->render('index', [
            'quiz' => $quiz,
            'quizCharacters' => $_quizCharacters,
            'quizInputGroups' => $_quizInputGroups,
            'quizParams' => $_quizParams,
            'quizInputGroupFilters' => $_quizInputGroupFilters,
            'quizCharacterFilters' => [],
            'quizResultFilters' => [],
//            'quizResults' => $quizResults,
        ]);
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