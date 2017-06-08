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

class BaseController extends Controller
{
    public $menu;

    public function beforeAction($action)
    {
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