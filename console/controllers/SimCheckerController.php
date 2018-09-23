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
            $result = [];
            try {
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
                foreach ($dom->find('.col-number a') as $item) {
                    $result[] = (string) $item->innerHTML;
                }
                $dom = null;
            } catch (\Exception $e) {
            }
            return $result;
        };
        $viettel_url = 'https://shop.viettel.vn/ajax/tim-kiem-sim?is_commitment=1&number=09%2A&_=1537671972612&page=';
        $numbers = [];
        for ($page = 0; $page < 40/*36*/; $page++) {
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
            echo "\n=============\n";
            echo $number;
            $url = 'http://xemboisim.vn/xem-boi-so-dien-thoai.htm';
            $data = [
                'sosim' => $number,
//                'check' => 'Xem',
                'ngay' => '23',// '16',
                'thang' => '6',// '9',
                'nam' => '1991',// '1993',
                'gioitinh' => 'Nam',
                'giosinh' => '17 giờ đến 19 giờ',// '5 giờ đến 7 giờ',
//                'option' => 'com_boi',
//                'view' => 'simdep',
//                'Itemid' => '34',
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
            try {
                $result = file_get_contents($url, false, $context);
            } catch (\Exception $e) {
                continue;
            }
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
            $kl = $dom->find('.tong_diem b', 0);
            if ($kl) {
                $pos = strpos($kl->innerHTML, '/10');
                if ($pos !== false) {
                    $score = (float) str_replace(['Tổng điểm ', '/10'], ['', ''], $kl->innerHTML);
                    echo ': ' . $score;
                    $number_list[] = [$number, $score];
                }
            }
        }
        usort($number_list, function ($a, $b) {
            if ($b[1] > $a[1]) return 1;
            if ($a[1] > $b[1]) return -1;
            return 0;
        });
        $file = fopen(\Yii::getAlias('@console/runtime/quan_number_list') . date('_Ymd_His') . '.txt', 'w');
        fwrite($file, json_encode($number_list, JSON_PRETTY_PRINT));
        fclose($file);
    }
}