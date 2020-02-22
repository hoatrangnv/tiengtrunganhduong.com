<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2/15/2020
 * Time: 12:24 PM
 */

namespace console\controllers;


use common\models\ChinesePhrasePhonetic;
use yii\console\Controller;

class ChinesePhrasePhoneticController extends Controller
{
    public function actionImportData() {
        $source = file_get_contents(dirname(__DIR__) . '/data/tiengtrungboifull.json');
        $sourceArr = json_decode($source, true);
        echo count($sourceArr);
        foreach ($sourceArr as $item) {
            $simplifiedPhrase = $item[0];
            $traditionalPhrase = $item[1];
            $phonetic = $item[2];
            $viPhonetic = $item[3];
            $meaning = $item[4];
            if ($simplifiedPhrase === $traditionalPhrase) {
                self::saveRecord(0, $simplifiedPhrase, $phonetic, $viPhonetic, $meaning);
            } else {
                self::saveRecord(1, $simplifiedPhrase, $phonetic, $viPhonetic, $meaning);
                self::saveRecord(2, $traditionalPhrase, $phonetic, $viPhonetic, $meaning);
            }
        }
    }

    static function saveRecord($type, $phrase, $phonetic, $viPhonetic, $meaning) {
        $record = new ChinesePhrasePhonetic();
        $record->type = $type;
        $record->phrase = $phrase;
        $record->phonetic = $phonetic;
        $record->vi_phonetic = $viPhonetic;
        $record->meaning = $meaning;
        try {
            if (!$record->save()) {
                echo json_encode($record->errors);
            }
        } catch (\Exception $exception) {
            echo $exception->getMessage();
        }
    }
}