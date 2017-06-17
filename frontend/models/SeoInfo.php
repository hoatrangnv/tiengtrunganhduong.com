<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 6/17/2017
 * Time: 12:22 AM
 */

namespace frontend\models;

use Yii;
use yii\helpers\Url;
use yii\web\View;

class SeoInfo extends \common\models\SeoInfo
{
    /**
     * @return SeoInfo
     */
    public static function findOneByRequestInfo()
    {
//        $url_path = parse_url(Yii::$app->request->absoluteUrl, PHP_URL_PATH);
//        $model = self::find()
//            ->where(['REGEXP', 'url', "$url_path"])
//            ->oneActive();

        $model = self::find()->where(['route' => Yii::$app->requestedRoute])->oneActive();
        return $model;
    }

    public function parseValues(Array $source)
    {
        foreach ($this->attributes as $name => $value) {
            if (isset($source[$name])) {
                $this->$name = $source[$name];
            }
        }
    }

    /**
     * @param View $view
     */
    public function registerMetaTags($view)
    {
        $context = $view->context;
        $view->registerMetaTag([
            'name' => 'description',
            'content' => $this->meta_description
        ], 'description');
        $view->registerMetaTag([
            'name' => 'keywords',
            'content' => $this->meta_keywords
        ], 'keywords');
        $view->registerMetaTag([
            'name' => 'robots',
            'content' => ($this->doindex ? 'index' : 'noindex') . ', ' . ($this->dofollow ? 'follow' : 'nofollow')
        ]);
        $view->registerMetaTag([
            'name' => 'robots',
            'content' => 'NOODP, NOYDIR'
        ]);
        $view->registerMetaTag([
            'name' => 'geo.region',
            'content' => 'VN-HN'
        ], 'geo.region');
        $view->registerMetaTag([
            'name' => 'geo.placename',
            'content' => 'Hà Nội'
        ]);
        $view->registerMetaTag([
            'name' => 'geo.position',
            'content' => '21.033953;105.785002'
        ]);
        $view->registerMetaTag([
            'name' => 'DC.Source',
            'content' => Url::home(true)
        ]);
        $view->registerMetaTag([
            'name' => 'DC.Coverage',
            'content' => 'Việt Nam'
        ]);
        $view->registerMetaTag([
            'name' => 'RATING',
            'content' => 'GENERAL'
        ]);
        $view->registerMetaTag([
            'name' => 'COPYRIGHT',
            'content' => Yii::$app->name
        ]);
        $view->registerMetaTag([
            'property' => 'og:type',
            'content' => 'website'
        ]);
        $view->registerMetaTag([
            'property' => 'og:title',
            'content' => $this->meta_title
        ]);
        $view->registerMetaTag([
            'property' => 'og:description',
            'content' => $this->meta_description
        ]);
        if (property_exists($context, 'canonicalLink')) {
            $view->registerMetaTag([
                'property' => 'og:url',
                'content' => $context->canonicalLink
            ]);
        }
        if ($this->image) {
            $view->registerMetaTag([
                'property' => 'og:image',
                'content' => $this->image->getSource()
            ]);
        }
        $view->registerMetaTag([
            'property' => 'og:site_name',
            'content' => Yii::$app->name
        ]);
        $view->registerMetaTag([
            'property' => 'REVISIT-AFTER',
            'content' => '1 DAYS'
        ]);
        $view->registerMetaTag([
            'name' => 'viewport',
            'content' => 'width=device-width, initial-scale=1'
        ]);
    }

    /**
     * @param View $view
     */
    public function registerLinkTags($view)
    {
        $context = $view->context;
        if (property_exists($context, 'canonicalLink')) {
            $view->registerLinkTag([
                'rel' => 'canonical',
                'href' => $context->canonicalLink
            ]);
        }
        if ($this->image) {
            $view->registerLinkTag([
                'rel' => 'image_src',
                'type' => $this->image->mime_type,
                'href' => $this->image->getSource()
            ]);
        }
        $view->registerLinkTag([
            'rel' => 'shortcut icon',
            'href' => Yii::getAlias('@web/favicon.ico')
        ]);
    }
}