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
        $quizCharacters = $quiz->quizCharacters;
        $quizInputGroups = $quiz->quizInputGroups;
        $quizParams = $quiz->quizParams;
        $quizObjectFilters = $quiz->quizObjectFilters;
        $quizAlerts = $quiz->quizAlerts;
        $quizResults = $quiz->quizResults;
        $quizShapes = $quiz->quizShapes;
        $quizInputValidators = $quiz->quizInputValidators;
        $quizStyles = $quiz->quizStyles;

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
                    $quizInputOptionToVotedResults = $item3->quizInputOptionToVotedResults;
                    $quiz_results_votes = [];
                    foreach ($quizInputOptionToVotedResults as $result_votes) {
                        $quiz_results_votes[$result_votes->quiz_voted_result_id] = $result_votes->votes;
                    }
                    $attrs3['quiz_results_votes'] = $quiz_results_votes;
                    return $attrs3;
                }, $quizInputOptions);
                $attrs2['quizInputOptions'] = $_quizInputOptions;

                $quizInputValidators = $item2->quizInputValidators;
//                $_quizInputValidators = array_map(function ($item3) {
//                    /**
//                     * @var $item3 QuizInputValidator
//                     */
//                    $attrs3 = $item3->attributes;
//                    $quizFn = $item3->quizFn;
//                    $_quizFn = $quizFn->attributes;
//                    $attrs3['quizFn'] = $_quizFn;
//                    return $attrs3;
//                }, $quizInputValidators);
//                $attrs2['quizInputValidators'] = $_quizInputValidators;
                $attrs2['quiz_input_validator_ids'] = array_map(function ($item) {
                    return $item->id;
                }, $quizInputValidators);

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
            $quizSorters = $item->quizCharacterDataSorters;
            $_quizSorters = array_map(function ($item2) {
                /**
                 * @var $item2 QuizCharacterDataSorter
                 */
                $attrs2 = $item2->attributes;
                $quizFn = $item2->quizFn;
                $_quizFn = $quizFn->attributes;
                $attrs2['quizFn'] = $_quizFn;
                return $attrs2;
            }, $quizSorters);
            $quizFilters = $item->quizCharacterDataFilters;
            $_quizFilters = array_map(function ($item2) {
                /**
                 * @var $item2 QuizCharacterDataFilter
                 */
                $attrs2 = $item2->attributes;
                $quizFn = $item2->quizFn;
                $_quizFn = $quizFn->attributes;
                $attrs2['quizFn'] = $_quizFn;
                return $attrs2;
            }, $quizFilters);
            $quizCharacterMedia = $item->quizCharacterMedia;
            $_quizCharacterMedia = array_map(function ($item2) {
                /**
                 * @var $item2 QuizCharacterMedium
                 */
                $attrs2 = $item2->attributes;

                $quizCharacterMediumDataFilters = $item2->quizCharacterMediumDataFilters;
                $_quizCharacterMediumDataFilters = array_map(function ($item3) {
                    /**
                     * @var $item3 QuizCharacterMediumDataFilter
                     */
                    $attrs3 = $item3->attributes;
                    $quizFn = $item3->quizFn;
                    $_quizFn = $quizFn->attributes;
                    $attrs3['quizFn'] = $_quizFn;
                    return $attrs3;
                }, $quizCharacterMediumDataFilters);

                $quizCharacterMediumDataSorters = $item2->quizCharacterMediumDataSorters;
                $_quizCharacterMediumDataSorters = array_map(function ($item3) {
                    /**
                     * @var $item3 QuizCharacterMediumDataSorter
                     */
                    $attrs3 = $item3->attributes;
                    $quizFn = $item3->quizFn;
                    $_quizFn = $quizFn->attributes;
                    $attrs3['quizFn'] = $_quizFn;
                    return $attrs3;
                }, $quizCharacterMediumDataSorters);

                $quizStyles = $item2->quizStyles;
                $_quizStyleIds = array_map(function ($item3) {
                    /**
                     * @var $item3 QuizStyle;
                     */
                    return $item3->id;
                }, $quizStyles);
                $attrs2['quizCharacterMediumDataFilters'] = $_quizCharacterMediumDataFilters;
                $attrs2['quizCharacterMediumDataSorters'] = $_quizCharacterMediumDataSorters;
                $attrs2['quiz_style_ids'] = $_quizStyleIds;
                return $attrs2;
            }, $quizCharacterMedia);
            $attrs['quizCharacterDataSorters'] = $_quizSorters;
            $attrs['quizCharacterDataFilters'] = $_quizFilters;
            $attrs['quizCharacterMedia'] = $_quizCharacterMedia;
            return $attrs;
        }, $quizCharacters);

        $_quizParams = array_map(function ($item) {
            /**
             * @var $item QuizParam
             */
            $attrs = $item->attributes;
            $quizFn = $item->quizFn;
            $_quizFn = $quizFn->attributes;
            $attrs['quizFn'] = $_quizFn;
            return $attrs;
        }, $quizParams);

        $_quizObjectFilters = array_map(function ($item) {
            /**
             * @var $item QuizObjectFilter;
             */
            $attrs = $item->attributes;
            $quizFn = $item->quizFn;
            $_quizFn = $quizFn->attributes;
            $attrs['quizFn'] = $_quizFn;
            return $attrs;
        }, $quizObjectFilters);

        $_quizAlerts = array_map(function ($item) {
            /**
             * @var $item QuizAlert
             */
            $attrs = $item->attributes;
            return $attrs;
        }, $quizAlerts);

        $_quizResults = array_map(function ($item) {
            /**
             * @var $item QuizResult
             */
            $attrs = $item->attributes;
            $quizCharacterMedia = $item->quizCharacterMedia;
            $quizShapes = $item->quizShapes;
            $attrs['quiz_character_medium_ids'] = array_map(function ($item) {
                return $item->id;
            }, $quizCharacterMedia);
            $attrs['quiz_shape_ids'] = array_map(function ($item) {
                return $item->id;
            }, $quizShapes);
            return $attrs;
        }, $quizResults);

        $_quizShapes = array_map(function ($item) {
            /**
             * @var $item QuizShape
             */
            $attrs = $item->attributes;
            $quizStyles = $item->quizStyles;
            $attrs['quiz_style_ids'] = array_map(function ($item) {
                return $item->id;
            }, $quizStyles);
            $attrs['image_src'] = $item->image ? $item->image->getSource() : '';
            return $attrs;
        }, $quizShapes);
        $_quizStyles = array_map(function ($item) {
            /**
             * @var $item QuizStyle
             */
            $attrs = $item->attributes;
            return $attrs;
        }, $quizStyles);
        $_quizInputValidators = array_map(function ($item) {
            /**
             * @var $item QuizInputValidator
             */
            $attrs = $item->attributes;
            $quizFn = $item->quizFn;
            $_quizFn = $quizFn->attributes;
            $attrs['quizFn'] = $_quizFn;
            return $attrs;
        }, $quizInputValidators);


        return $this->render('index', [
            'quiz' => $quiz,
            'quizCharacters' => $_quizCharacters,
            'quizInputGroups' => $_quizInputGroups,
            'quizParams' => $_quizParams,
            'quizObjectFilters' => $_quizObjectFilters,
            'quizResults' => $_quizResults,
            'quizAlerts' => $_quizAlerts,
            'quizShapes' => $_quizShapes,
            'quizInputValidators' => $_quizInputValidators,
            'quizStyles' => $_quizStyles,
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