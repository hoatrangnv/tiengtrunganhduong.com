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
    const INPUT_MAX_WORDS = 20;
    const PHRASE_MAX_WORDS = 6;

    public function actionLookup() {
        $response = ['data' => null, 'error_message' => null];
        $clause = \Yii::$app->request->get('clause');
//        https://stackoverflow.com/questions/4113802/how-to-split-chinese-characters-in-php
//        preg_match_all('/(\w+)|(.)/u', $clause, $matches);
        preg_match_all('/./u', $clause, $matches);
        $words = array_values(array_filter($matches[0], function ($word) {
            return $word !== ' ' && $word !== '';
        }));
        $response['data']['words'] = $words;
        $clauseNumWords = count($words);
        if ($clauseNumWords > self::INPUT_MAX_WORDS) {
            $response['error_message'] = "Number of words received: " . $clauseNumWords .". Max allowed: " . self::INPUT_MAX_WORDS;
            return $response;
        }

        $phraseMaxWords = min($clauseNumWords, self::PHRASE_MAX_WORDS);
        $response['data']['phraseMaxWords'] = $phraseMaxWords;

        $allPhrases = [];
        $uniquePhrasesObj = [];
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
        $uniquePhrases = array_keys($uniquePhrasesObj);
//        $response['data']['allPhrases'] = $allPhrases;
//        $response['data']['uniquePhrases'] = $uniquePhrases;

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