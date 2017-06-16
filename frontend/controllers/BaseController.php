<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 4/5/2017
 * Time: 12:38 AM
 */

namespace frontend\controllers;

use frontend\models\Article;
use frontend\models\ArticleCategory;
use frontend\models\SeoInfo;
use Yii;
use yii\web\Controller;
use vanquyet\menu\Menu;
use yii\helpers\Url;
use Detection\MobileDetect;

class BaseController extends Controller
{
    public $menu;
    public $screen;
    public $meta = [
        'description' => '',
        'keywords' => '',
        'robots' => 'index, follow',
        'geo.region' => 'VN-HN',
        'geo.placename' => 'Hà Nội',
        'geo.position' => '21.033953;105.785002',
    ];

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
        $data0 = [];
        $data0['home_page'] = [
            'label' => Yii::t('app', 'Home page'),
            'url' => Url::home(true),
            'parentKey' => null
        ];
        $models = array_merge(
            array_filter(ArticleCategory::indexData(), function ($item) {
                return 1 == $item->shown_on_menu;
            }),
            Article::find()->where(['shown_on_menu' => 1])->allPublished()
        );
        usort($models, function ($a, $b) {
//            if (!property_exists($a, 'sort_order') || !property_exists($b, 'sort_order')) {
//                return 0;
//            }
            return $a->sort_order - $b->sort_order;
        });
        $data1 = [];
        foreach ($models as $model) {
            $model_type = '';
            if ($model instanceof ArticleCategory) {
                $model_type = 'category';
            } else if ($model instanceof Article) {
                $model_type = 'article';
            }
            if (1 == $model->shown_on_menu) {
                $data1["{$model_type}__{$model->id}"] = [
                    'label' => $model->name,
                    'url' => $model->getUrl(),
                    'parentKey' => !$model->hasAttribute('parent_id')
                        ? null
                        : ($model->parent_id ? "{$model_type}__{$model->parent_id}" : null),
                ];
            }
        }

        $data2 = [];
        $data2['contact'] = [
            'label' => Yii::t('app', 'Contact'),
            'url' => Url::to(['site/contact'], true),
            'parentKey' => null
        ];

        $this->menu = new Menu();
        $this->menu->init(['d0' => $data0, 'd1' => $data1, 'd2' => $data2]);

        // @TODO: Find Seo Info
        if ($seo = SeoInfo::findOneByRequestInfo()) {

        }

        return parent::beforeAction($action);
    }
}