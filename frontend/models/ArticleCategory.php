<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 6/9/2017
 * Time: 1:59 AM
 */

namespace frontend\models;

use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use common\models\UrlParam;
use Yii;

/**
 * Class ArticleCategory
 * @package frontend\models
 *
 * @property Article[] $articles
 * @property User $creator
 * @property User $updater
 * @property Image $image
 * @property ArticleCategory $parent
 * @property ArticleCategory[] $articleCategories
 */

class ArticleCategory extends \common\models\ArticleCategory
{
    public function getUrl($params = [], $schema = true)
    {
        if (Yii::$app->params['amp']) {
            $params[UrlParam::AMP] = 'amp';
        }
        return Url::to(array_merge(['article/category', UrlParam::SLUG => $this->slug], $params), $schema);
    }

    public function img($size = null, array $options = [], array $srcOptions = [])
    {
        if (Yii::$app->params['amp']) {
            if (!isset($options['width'])) {
                $options['width'] = 300;
            }
            if (!isset($options['height'])) {
                $options['height'] = 200;
            }
            $options['layout'] = 'responsive';
        }
        $tag = parent::img($size, $options, $srcOptions);
        if (Yii::$app->params['amp']) {
            $tag = str_replace('<img', '<amp-img', $tag);
        }
        return $tag;
    }

    private static $_indexData;

    /**
     * @param bool $visibleOnly
     * @return self[]
     */
    public static function indexData($visibleOnly = false)
    {
        if (self::$_indexData == null) {
            self::$_indexData = self::find()
                ->orderBy('sort_order asc')
                ->indexBy('id')
                ->allActive();
        }

        if ($visibleOnly) {
            return array_filter(self::$_indexData, function ($item) {
                return 1 == $item->visible;
            });
        }
        return self::$_indexData;
    }

    /**
     * @return \common\models\MyActiveQuery
     */
    public function getAllArticles()
    {
        $query = Article::find();
        $query->where([
            'in',
            'category_id',
            array_merge(
                [$this->id],
                ArrayHelper::getColumn($this->findChildren(), 'id')
            )
        ]);
        $query->multiple = true;
        return $query;
    }

    /**
     * @param $slug
     * @return self | null
     */
    public static function findOneBySlug($slug)
    {
        $data = static::indexData();
        foreach ($data as $item) {
            if ($item->slug == $slug) {
                return $item;
            }
        }
        return null;
    }

    public static function findOneByType($type)
    {
        $data = static::indexData();
        foreach ($data as $item) {
            if ($item->type == $type) {
                return $item;
            }
        }

        return null;
    }

    /**
     * @param $id
     * @return ArticleCategory|null
     */
    public static function findOneById($id)
    {
        $data = static::indexData();
        return isset($data[$id]) ? $data[$id] : null;
    }

    public $_parent = 1;

    /**
     * @return ArticleCategory|null
     */
    public function findParent()
    {
        if ($this->parent_id === null) {
            return null;
        }

        if ($this->_parent === 1) {
            $this->_parent = self::findOneById($this->parent_id);
        }

        return $this->_parent;
    }

    public $_children = 1;
    public function findChildren()
    {
        if ($this->_children === 1) {
            $this->_children = [];
            $items = static::indexData();
            foreach ($items as $item) {
                if ($item->parent_id == $this->id) {
                    $this->_children[] = $item;
                }
            }
        }

        return $this->_children;
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(Article::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreator()
    {
        return $this->hasOne(User::className(), ['id' => 'creator_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdater()
    {
        return $this->hasOne(User::className(), ['id' => 'updater_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'image_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(ArticleCategory::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticleCategories()
    {
        return $this->hasMany(ArticleCategory::className(), ['parent_id' => 'id']);
    }

}