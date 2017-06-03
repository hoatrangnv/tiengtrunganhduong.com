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

class CrawlController extends Controller
{
    const SITEMAP_FILENAME = __DIR__ . '/../data/sitemap.xml';


    public function actionIndex()
    {
        $sitemap_content = file_get_contents(self::SITEMAP_FILENAME);
//        echo strlen($sitemap_content);
        $dom = new Dom;
        $dom->load(substr($sitemap_content, 0, 50000));
        foreach ($dom->find('url > loc') as $item) {
            $crawler = new CrawledPage();
            $crawler->url = $item->innerHTML;

            $relative_url = str_replace('http://tiengtrunganhduong.com/', '', $crawler->url);

            if (strpos($relative_url, '/') === false && substr($relative_url, -4) === '.htm') {

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