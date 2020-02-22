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
    const INPUT_MAX_WORDS = 500;
    const CLAUSE_MAX_WORDS = 50;
    const PHRASE_MAX_WORDS = 5;

    public function actionLookup() {
        $time = microtime(true);
        $response = ['data' => null, 'error_message' => null];
        $clausesJson = \Yii::$app->request->post('clauses', null);
        try {
            $clauses = array_values(json_decode($clausesJson, true));
        } catch (\Exception $exception) {
            $response['error_message'] = $exception->getMessage();
            return $response;
        }
        $executedClausesInfo = [];
        $phraseAddresses = [];
        $totalExecutedWords = 0;
        foreach ($clauses as $clauseIndex => $words) {
            $clauseNumWords = count($words);
            $exportItem = ['words' => $words];
            if ($clauseNumWords > self::CLAUSE_MAX_WORDS) {
                $exportItem['error'] = 'Mệnh đề quá dài: ' . $clauseNumWords . ' từ. Vui lòng chia thành các mệnh đề nhỏ (sử dụng dấu "chấm" hoặc "phẩy") với nhiều nhất ' . self::CLAUSE_MAX_WORDS . ' từ.';
                $executedClausesInfo[] = $exportItem;
                continue;
            }
            $totalExecutedWords += $clauseNumWords;
            if ($totalExecutedWords > self::INPUT_MAX_WORDS) {
                $exportItem['words'] = null; // indicates this is the end
                $exportItem['error'] = 'Văn bản vượt quá tổng số từ có thể xử lý. Tối đa: ' . self::INPUT_MAX_WORDS . ' từ.';
                $executedClausesInfo[] = $exportItem;
                break;
            }
            $phraseMaxWords = min($clauseNumWords, self::PHRASE_MAX_WORDS);

            // execute
            for ($phraseNumWords = 1; $phraseNumWords <= $phraseMaxWords; $phraseNumWords++) {
                for ($startWordIndex = 0; $startWordIndex < $clauseNumWords - $phraseNumWords + 1; $startWordIndex++) {
                    $phrase = '';
                    for ($endWordIndex = $startWordIndex; $endWordIndex < $startWordIndex + $phraseNumWords; $endWordIndex++) {
                        $phrase .= $words[$endWordIndex];
                    }
                    // *Note that after finish loop, endWordIndex was be increase 1 before condition checking
                    // startWordIndex === start slice index
                    // endWordIndex++ === end slice index
                    $address = [$clauseIndex, $startWordIndex, $endWordIndex];
                    if (!isset($phraseAddresses[$phrase])) {
                        $phraseAddresses[$phrase] = [ $address ];
                    } else {
                        $phraseAddresses[$phrase][] = $address;
                    }
                }
            }

            $exportItem['phrasesData'] = [];
            $executedClausesInfo[] = $exportItem;
        }

        /**
         * @var $phoneticRecords ChinesePhrasePhonetic[]
         */
        $phoneticRecords = ChinesePhrasePhonetic::find()
            ->select(['phrase', 'phonetic', 'vi_phonetic', 'meaning', 'type'])
            ->where(['IN', 'phrase', array_map('strval', array_keys($phraseAddresses))])
            ->all();
        $phrasesDetails = [];
        foreach ($phoneticRecords as $record) {
            $upper = strtoupper($record->phrase);
            $lower = strtolower($record->phrase);
            if ($upper === $lower) {
                $addressList = $phraseAddresses[$upper];
            } else {
                if (isset($phraseAddresses[$upper])) {
                    if (isset($phraseAddresses[$lower])) {
                        $addressList = array_merge($phraseAddresses[$upper], $phraseAddresses[$lower]);
                    } else {
                        $addressList = $phraseAddresses[$upper];
                    }
                } else {
                    $addressList = $phraseAddresses[$lower];
                }
            }
            $phrasesDetails[$upper] = [$record->meaning, $record->type];
            foreach ($addressList as $address) {
                $executedClausesInfo[$address[0]]['phrasesData'][1900000 - $address[1] * 1000 - $address[2]] = [
                    $record->phonetic,
                    $record->vi_phonetic,
                ];
            }
        }
        $response['data']['executedClausesInfo'] = $executedClausesInfo;
        $response['data']['phrasesDetails'] = $phrasesDetails;
        $response['data']['time'] = microtime(true) - $time;

        return $response;
    }
}