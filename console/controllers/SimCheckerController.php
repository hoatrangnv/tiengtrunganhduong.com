<?php
/**
 * Created by PhpStorm.
 * User: Quyet
 * Date: 6/21/2017
 * Time: 8:26 AM
 */

namespace console\controllers;


use PHPHtmlParser\Dom;
use yii\console\Controller;

class SimCheckerController extends Controller
{
    public function actionViettel()
    {
        $getNumbers = function ($url) {
            $page_content = file_get_contents($url);
            $dom = new Dom();
            $dom->loadStr($page_content, [
                'whitespaceTextNode' => true,
                'strict'             => false,
                'enforceEncoding'    => null,
                'cleanupInput'       => false,
                'removeScripts'      => false,
                'removeStyles'       => false,
                'preserveLineBreaks' => true,
            ]);
            $result = [];
            foreach ($dom->find('.table-simso .col-number a') as $item) {
                $result[] = (string) $item->innerHTML;
            }
            $dom = null;
            return $result;
        };
        $viettel_url = 'https://shop.viettel.vn/ajax/tim-kiem-sim?from_money=50000&to_money=22000000&total_point=&total_node=&number=09%2A&length%5B0%5D=10&_=1498007495126&page=';
        $numbers = [];
        for ($page = 0; $page < 21; $page++) {
            $numbers = array_merge($numbers, $getNumbers($viettel_url . $page));
        }
//        $file = fopen(\Yii::getAlias('@console/runtime/viettel.txt') . date('_Ymd_His'), 'w');
//        fwrite($file, json_encode($numbers));
//        fclose($file);
        $number_list = [];
        foreach ($numbers as $number) {
//            $wap_url = "http://lichvansu.wap.vn/xem-boi-so-dien-thoai-nam-16-09-1993-$number.html";
//            $wap_content = file_get_contents($wap_url);
////            $file = fopen(\Yii::getAlias('@console/runtime/wap_') . $number . '.txt', 'w');
////            fwrite($file, $wap_content);
////            fclose($file);
//            $dom = new Dom();
//            $dom->loadStr($wap_content, [
//                'whitespaceTextNode' => true,
//                'strict'             => false,
//                'enforceEncoding'    => null,
//                'cleanupInput'       => false,
//                'removeScripts'      => false,
//                'removeStyles'       => false,
//                'preserveLineBreaks' => true,
//            ]);
//            $abouts = $dom->find('span.about');
//            foreach ($abouts as $about) {
//                if (strpos($about->innerHTML, '/10') !== false) {
//                    $score = (float) substr($about->innerHTML, 0, -11);
//                    echo $score . "\n";;
//                    $number_list[] = [$number, $score];
//                }
//            }
            echo "=============\n";
            $url = 'http://xemboisim.vn/xem-boi-so-dien-thoai.htm';
            $data = [
                'sosim' => $number,
                'check' => 'Xem',
                'ngay' => '16',
                'thang' => '09',
                'nam' => '1993',
                'gioitinh' => 'Nam',
                'giosinh' => '5 giờ đến 7 giờ',
                'option' => 'com_boi',
                'view' => 'simdep',
                'Itemid' => '34',
            ];

            // use key 'http' even if you send the request to https://...
            $options = [
                'http' => [
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method'  => 'POST',
                    'content' => http_build_query($data)
                ]
            ];
            $context  = stream_context_create($options);
            $result = file_get_contents($url, false, $context);
            if ($result === FALSE) { /* Handle error */ }
            $dom = new Dom();
            $dom->loadStr($result, [
                'whitespaceTextNode' => true,
                'strict'             => false,
                'enforceEncoding'    => null,
                'cleanupInput'       => false,
                'removeScripts'      => false,
                'removeStyles'       => false,
                'preserveLineBreaks' => true,
            ]);
            $kl = $dom->find('.KL', 0);
            if ($kl) {
                $pos = strpos($kl->innerHTML, '/ 10');
                if ($pos !== false) {
                    $score = (float) substr($kl->innerHTML, $pos - 6, 5);
                    echo $number . ': ' . $score . "\n";
                    $number_list[] = [$number, $score];
                }
            }
        }
        usort($number_list, function ($a, $b) {
            return (float) $b[1] - (float) $a[1];
        });
        $file = fopen(\Yii::getAlias('@console/runtime/number_list') . date('_Ymd_His') . '.txt', 'w');
        fwrite($file, json_encode($number_list));
        fclose($file);
    }
}