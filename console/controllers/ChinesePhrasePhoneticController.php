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
            $phonetic = new ChinesePhrasePhonetic();
            $phonetic->phrase = $item[0];
            $phonetic->tw_phrase = $item[1];
            $phonetic->phonetic = $item[2];
            $phonetic->vi_phonetic = $item[3];
            $phonetic->meaning = $item[4];
            try {

            if (!$phonetic->save()) {
                echo json_encode($phonetic->errors);
            }
            } catch (\Exception $exception) {
                echo $exception->getMessage();
            }
        }
    }
}