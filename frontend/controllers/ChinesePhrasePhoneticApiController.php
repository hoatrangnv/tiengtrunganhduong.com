<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2/15/2020
 * Time: 2:32 PM
 */

namespace frontend\controllers;


use common\models\ChinesePhrasePhonetic;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;

class ChinesePhrasePhoneticApiController extends Controller
{
    const INPUT_MAX_CLAUSES = 10;
    const INPUT_MAX_WORDS = 20;
    const PHRASE_MAX_WORDS = 6;

    public function actionLookup() {
        $response = ['data' => null, 'error_message' => null];
        $wordsListJson = \Yii::$app->request->get('wordsList', null);
        try {
            $wordsList = array_values(json_decode($wordsListJson, true));
        } catch (\Exception $exception) {
            $response['error_message'] = $exception->getMessage();
            return $response;
        }
        $executedWordsInfo = [];
        $uniquePhrasesObj = [];
        foreach ($wordsList as $index => $words) {
            if ($index + 1 > self::INPUT_MAX_CLAUSES) {
                break;
            }
            $clauseNumWords = count($words);
            $exportItem = ['words' => $words];
            if ($clauseNumWords > self::INPUT_MAX_WORDS) {
                $exportItem['error'] = 'Mệnh đề quá dài: ' . $clauseNumWords . ' từ. Vui lòng chia thành các mệnh đề nhỏ (sử dụng dấu "chấm" hoặc "phẩy") với nhiều nhất ' . self::INPUT_MAX_WORDS . ' từ.';
                $executedWordsInfo[] = $exportItem;
                continue;
            }

            $phraseMaxWords = min($clauseNumWords, self::PHRASE_MAX_WORDS);
            $allPhrases = [];
            for ($phraseNumWords = 1; $phraseNumWords <= $phraseMaxWords; $phraseNumWords++) {
                for ($startWordIndex = 0; $startWordIndex < $clauseNumWords - $phraseNumWords + 1; $startWordIndex++) {
                    $phrase = '';
                    for ($i = $startWordIndex; $i < $startWordIndex + $phraseNumWords; $i++) {
                        $phrase .= $words[$i];
                    }
                    $allPhrases[] = $phrase;
                    $uniquePhrasesObj[$phrase] = true;
                }
            }
            $exportItem['phraseMaxWords'] = $phraseMaxWords;
            $executedWordsInfo[] = $exportItem;
        }
        $response['data']['executedWordsInfo'] = $executedWordsInfo;

        $uniquePhrases = array_keys($uniquePhrasesObj);
        /**
         * @var $phoneticRecords ChinesePhrasePhonetic[]
         */
        $phoneticRecords = ChinesePhrasePhonetic::find()->where(['IN', 'phrase', $uniquePhrases])->all();
        $phrasesData = [];
        foreach ($phoneticRecords as $record) {
            $phrasesData[$record->phrase] = [
                $record->phonetic,
                $record->vi_phonetic,
            ];
        }
        $response['data']['phrasesData'] = $phrasesData;

        return $response;
    }
}