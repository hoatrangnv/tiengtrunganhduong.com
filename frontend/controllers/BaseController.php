<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 4/5/2017
 * Time: 12:38 AM
 */

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use vanquyet\menu\Menu;
use yii\helpers\Url;
use Detection\MobileDetect;

class BaseController extends Controller
{
    public $menu;
    public $screen;

    public function beforeAction($action)
    {
        // @TODO: Determines screen size
        $detect = new MobileDetect;
        switch (true) {
            case $detect->isTablet(): // tablet only
                $this->screen = 'medium';
                break;
            case $detect->isMobile(): // mobile or tablet
                $this->screen = 'small';
                break;
            default:
                $this->screen = 'large';
        }

        // @TODO: Initializes menu
        $this->menu = new Menu();
        $this->menu->init(
            [
                'info' => [
                    'homePage' => [
                        'label' => 'Trang chủ',
                        'url' => Url::home(true),
                        'parentKey' => null
                    ],
                    'aboutPage' => [
                        'label' => 'Giới thiệu',
                        'url' => Url::to(['site/about'], true),
                        'parentKey' => null
                    ],
                    'teachers' => [
                        'label' => 'Giáo viên',
                        'url' => '#',
                        'parentKey' => 'aboutPage'
                    ]
                ]
            ]
        );

        return parent::beforeAction($action);
    }
}