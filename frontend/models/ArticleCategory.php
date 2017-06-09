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

class ArticleCategory extends \common\models\ArticleCategory
{
    public function getUrl($params = [])
    {
        return Url::to(array_merge(['article/category', UrlParam::SLUG => $this->slug], $params), true);
    }

    private static $_indexData;

    public static function indexData()
    {
        if (self::$_indexData == null) {
            self::$_indexData = self::find()->indexBy('id')
                ->orderBy('sort_order asc')->allActive();
        }

        return self::$_indexData;
    }

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

    public static function findOneById($id)
    {
        $data = static::indexData();
        return isset($data[$id]) ? $data[$id] : null;
    }

    public $_parent = 1;
    public function findParent()
    {
        if ($this->parent_id === null) {
            return false;
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

}