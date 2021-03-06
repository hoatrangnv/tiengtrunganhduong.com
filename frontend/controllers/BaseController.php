<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 4/5/2017
 * Time: 12:38 AM
 */

namespace frontend\controllers;

use common\models\MyActiveQuery;
use common\models\UrlParam;
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
    /** @var Menu $menu */
    public $menu;
    /** @var string $screen */
    public $screen;
    /** @var SeoInfo $seoInfo */
    public $seoInfo;
    /** @var string $canonicalLink */
    public $canonicalLink;
    /** @var string $ampLink */
    public $ampLink;

    public function beforeAction($action)
    {
        Yii::$app->params['amp'] = ('amp' === Yii::$app->request->get(UrlParam::AMP));

        // Canonical & AMP
        $reqParams = Yii::$app->request->get();
        $allAvailableParams = UrlParam::getAllParams();
        $canonicalParams = [];
        foreach ($reqParams as $paramName => $paramValue) {
            if (UrlParam::AMP !== $paramName && isset($allAvailableParams[$paramName])) {
                $canonicalParams[$paramName] = $paramValue;
            }
        }
        $this->canonicalLink = Url::to(array_merge([Yii::$app->requestedRoute], $canonicalParams), true);
        if (in_array(Yii::$app->requestedRoute, ['site/index', 'article/view'])) {
            if (!Yii::$app->params['amp']) {
                $this->ampLink = Url::to(array_merge([Yii::$app->requestedRoute], array_merge($canonicalParams, [UrlParam::AMP => 'amp'])), true);
            }
        }

        if (Yii::$app->params['amp']) {
            $this->layout = 'main';
            $this->viewPath = Yii::getAlias('@frontend/views/amp/') . $this->id;
            Yii::$app->layoutPath = Yii::getAlias('@frontend/views/amp/layouts');
        }

        // Determines screen size
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
            'label' => Yii::t('app', 'Homepage'),
            'url' => Url::home(true),
            'parentKey' => null
        ];
        $models = array_merge(
            array_filter(ArticleCategory::indexData(true), function ($item) {
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
            if (1 == $model->shown_on_menu) {
                $model_type = '';
                if ($model instanceof ArticleCategory) {
                    $model_type = 'category';
                } else if ($model instanceof Article) {
                    $model_type = 'article';
                }
                $data1["{$model_type}__{$model->id}"] = [
                    'label' => $model->menu_label ? $model->menu_label : $model->name,
                    'url' => $model->getUrl(),
                    'parentKey' => !$model->hasAttribute('parent_id')
                        ? null
                        : ($model->parent_id ? "{$model_type}__{$model->parent_id}" : null),
                ];
                // workaround to show sub-menu below tai-lieu item
                if ($model instanceof ArticleCategory) {
                    if ($model->slug === 'tai-lieu') {
                        $data1['phonetic'] = [
                            'label' => Yii::t('app', 'Translate Chinese'),
                            'url' => Url::to(['chinese-phonetic-lookup/index'], true),
                            'parentKey' => "{$model_type}__{$model->id}"
                        ];
                        $data1['quiz'] = [
                            'label' => Yii::t('app', 'Quiz'),
                            'url' => Url::to(['quiz/index'], true),
                            'parentKey' => "{$model_type}__{$model->id}"
                        ];
                    }
                }
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
        if (in_array(Yii::$app->requestedRoute, array_keys(SeoInfo::getRoutes()))) {
            $this->seoInfo = SeoInfo::findStaticSeoInfo();
        }
        if (!$this->seoInfo) {
            $this->seoInfo = new SeoInfo();
        }

        // this is a bad idea, fix this as soon as possible
        if (in_array(Yii::$app->requestedRoute, ['quiz/get-sharing-data'])) {
            return true;
        }

        return parent::beforeAction($action);
    }
}