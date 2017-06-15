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
        $data0 = [];
        $data0['home_page'] = [
            'label' => Yii::t('app', 'Home page'),
            'url' => Url::home(true),
            'parentKey' => null
        ];
//        $data1 = [
//            'news' => [
//                'label' => Yii::t('app', 'News'),
//                'url' => '#',
//                'parentKey' => null
//            ],
//            'service' => [
//                'label' => Yii::t('app', 'Courses and tuition fees'),
//                'url' => '#',
//                'parentKey' => null
//            ],
//            'document' => [
//                'label' => Yii::t('app', 'Documents'),
//                'url' => '#',
//                'parentKey' => null
//            ],
//        ];
//        foreach (ArticleCategory::indexData() as $category) {
//            if (!$category->parent_id && in_array($category->type, array_keys(ArticleCategory::getTypes()))) {
//                $data1[$category->id] = [
//                    'label' => $category->name,
//                    'url' => $category->getUrl(),
//                    'parentKey' => $category->type == ArticleCategory::TYPE_NEWS ? 'news'
//                        : ($category->type == ArticleCategory::TYPE_SERVICE ? 'service' : 'document')
//                ];
//            }
//        }
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
            if ($model->shown_on_menu == 1) {
                $data1["{$model_type}_{$model->id}"] = [
                    'label' => $model->name,
                    'url' => $model->getUrl(),
                    'parentKey' => (property_exists($model, 'parent_id') && $model->parent_id) ? "{$model_type}_{$model->parent_id}" : null,
                ];
            }
        }

        $this->menu = new Menu();
        $this->menu->init(['_' => $data0, '__' => $data1]);

        return parent::beforeAction($action);
    }
}