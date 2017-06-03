<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 6/3/2017
 * Time: 10:34 AM
 */

namespace console\controllers;


use console\models\CrawledPage;
use yii\console\Controller;
use PHPHtmlParser\Dom;
use yii\base\Module;

class CrawlController extends Controller
{
    public static $sitemap_filename;

    public function beforeAction($action)
    {
        self::$sitemap_filename = __DIR__ . '/../data/sitemap.xml';
        return parent::beforeAction($action); // TODO: Change the autogenerated stub
    }

    public function actionIndex()
    {
        $sitemap_content = file_get_contents(self::$sitemap_filename);
//        echo strlen($sitemap_content);
        $dom = new Dom;
        $offset = strpos($sitemap_content, 'ten-tieng-trung-63-tinh-thanh-va-quan-huyen.htm');
        $sitemap_sub_content = '<?xml version="1.0" encoding="UTF-8"?>'
            . ' <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"> <url> <loc>'
            . substr($sitemap_content, $offset);
        $dom->load($sitemap_sub_content);
        foreach ($dom->find('url > loc') as $item) {
            $url = $item->innerHTML;
            if (!$crawler = CrawledPage::find()->where(['url' => $url])->one()) {
                $crawler = new CrawledPage();
            }
            $crawler->url = $url;

            $relative_url = str_replace('http://tiengtrunganhduong.com/', '', $crawler->url);

            if (substr($relative_url, -4) === '.htm') {

                $item_content = file_get_contents($crawler->url);
                $item_dom = new Dom;
                $item_dom->load($item_content);
                $crawler->content = $item_dom->find('html')[0]->innerHTML;
                if ($crawler->save()) {
                    echo $relative_url . "\n";
                } else {
                    var_dump($crawler->getErrors());
                }

            }
        }
//        var_dump($dom->find('url > loc'));
    }
}