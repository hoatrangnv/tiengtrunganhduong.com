<?php
namespace common\models;

use Yii;
use yii\db\ActiveQuery;
use yii\di\Instance;
use yii\db\ActiveQueryInterface;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MyActiveQuery
 *
 * @author Quyet Tran <quyettvq at gmail.com>
 */
class MyActiveQuery extends ActiveQuery implements ActiveQueryInterface
{
    /**
     * @var bool
     */
    public $enableCache = true;

    /**
     * @var int
     */
    public $cacheDuration = 3600;

    /**
     * @var int
     */
    public $publishTimeWrongNumber = 300;

    /**
     * @var string
     */
    public $activeAttribute = 'active';

    /**
     * @var string
     */
    public $visibleAttribute = 'visible';

    /**
     * @var string
     */
    public $publishTimeAttribute = 'publish_time';

    /**
     * MyActiveQuery constructor.
     * @param string $modelClass
     * @param array $config
     */
    public function __construct($modelClass, array $config = [])
    {
        if (isset(Yii::$app->params['myActiveQuery'])) {
            foreach (Yii::$app->params['myActiveQuery'] as $key => $value) {
                if ($this->hasProperty($key)) {
                    $config[$key] = $value;
                }
            }
        }

        parent::__construct($modelClass, $config);
    }

    /**
     * @param $attribute
     * @return $this
     */
    public function is($attribute)
    {
        return $this->andWhere([$attribute => 1]);
    }

    /**
     * @param $attribute
     * @return $this
     */
    public function isNot($attribute)
    {
        return $this->andWhere([$attribute => 0]);
    }

    /** ACTIVE */

    /**
     * @return $this
     */
    public function active()
    {
        return $this->is($this->activeAttribute);
    }

    /**
     * @param null $db
     * @return array|bool|mixed|null|string|\yii\db\ActiveRecord
     */
    public function oneActive($db = null)
    {
        return $this->active()->one($db);
    }

    /**
     * @param null $db
     * @return array|bool|mixed|\yii\db\ActiveRecord[]
     */
    public function allActive($db = null)
    {
        return $this->active()->all($db);
    }

    /**
     * @param string $q
     * @param null $db
     * @return bool|int|mixed|string
     */
    public function countActive($q = '*', $db = null)
    {
        return $this->active()->count($q, $db);
    }

    /** VISIBLE */

    /**
     * @return $this
     */
    public function visible()
    {
        return $this->active()->is($this->visibleAttribute);
    }

    /**
     * @param null $db
     * @return array|bool|mixed|null|string|\yii\db\ActiveRecord
     */
    public function oneVisible($db = null)
    {
        return $this->visible()->one($db);
    }

    /**
     * @param null $db
     * @return array|bool|mixed|\yii\db\ActiveRecord[]
     */
    public function allVisible($db = null)
    {
        return $this->visible()->all($db);
    }

    /**
     * @param string $q
     * @param null $db
     * @return bool|int|mixed|string
     */
    public function countVisible($q = '*', $db = null)
    {
        return $this->visible()->count($q, $db);
    }

    /** PUBLISHED */

    /**
     * @param null $wrong_number
     * @return $this
     */
    public function published($wrong_number = null)
    {
        if ($wrong_number === null) {
            $wrong_number = $this->publishTimeWrongNumber;
        }

        $time = (int) round(time() / $wrong_number) * $wrong_number;
        
        return $this->visible()->andWhere(['<=', $this->publishTimeAttribute, $time]);
    }

    /**
     * @param null $db
     * @return array|bool|mixed|null|string|\yii\db\ActiveRecord
     */
    public function onePublished($db = null)
    {
        return $this->published()->one($db);
    }

    /**
     * @param null $db
     * @return array|bool|mixed|\yii\db\ActiveRecord[]
     */
    public function allPublished($db = null)
    {
        return $this->published()->all($db);
    }

    /**
     * @param string $q
     * @param null $db
     * @return bool|int|mixed|string
     */
    public function countPublished($q = '*', $db = null)
    {
        return $this->published()->count($q, $db);
    }

    /** UNPUBLISHED */

    /**
     * @param null $wrong_number
     * @return $this
     */
    public function unpublished($wrong_number = null)
    {
        if ($wrong_number === null) {
            $wrong_number = $this->publishTimeWrongNumber;
        }

        $time = (int) round(time() / $wrong_number) * $wrong_number;

        return $this->visible()->andWhere(['>', $this->publishTimeAttribute, $time]);
    }

    /**
     * @param null $db
     * @return array|bool|mixed|null|string|\yii\db\ActiveRecord
     */
    public function oneUnpublished($db = null)
    {
        return $this->unpublished()->one($db);
    }

    /**
     * @param null $db
     * @return array|bool|mixed|\yii\db\ActiveRecord[]
     */
    public function allUnpublished($db = null)
    {
        return $this->unpublished()->all($db);
    }

    /**
     * @param string $q
     * @param null $db
     * @return bool|int|mixed|string
     */
    public function countUnpublished($q = '*', $db = null)
    {
        return $this->unpublished()->count($q, $db);
    }

    /** CACHING */

    /**
     * @param null $db
     * @return array|bool|mixed|\yii\db\ActiveRecord[]
     */
    public function all($db = null)
    {
        $result = false;
        $cache_key = $this->getCacheKey(__METHOD__, $db);
        if ($this->enableCache) {
            $result = Yii::$app->cache->get($cache_key);
        }
        if (!$this->enableCache || $result === false) {
            $result = parent::all($db);
            if ($this->enableCache) {
                Yii::$app->cache->set($cache_key, $result, $this->cacheDuration);
            }
        }
        return $result;
    }

    /**
     * @param null $db
     * @return array|bool|mixed|null|string|\yii\db\ActiveRecord
     */
    public function one($db = null)
    {
        $result = false;
        $cache_key = $this->getCacheKey(__METHOD__, $db);
        if ($this->enableCache) {
            $result = Yii::$app->cache->get($cache_key);
        }
        if (!$this->enableCache || $result === false) {
            $result = parent::one($db);
            if ($result === false) {
                $result = 'F';
            }
            if ($this->enableCache) {
                Yii::$app->cache->set($cache_key, $result, $this->cacheDuration);
            }
        }
        if ($result === 'F') {
            $result = false;
        }
        return $result;
    }

    /**
     * @param string $q
     * @param null $db
     * @return bool|int|mixed|string
     */
    public function count($q = '*', $db = null)
    {
        $result = false;
        $cache_key = $this->getCacheKey(__METHOD__, [$db, $q]);
        if ($this->enableCache) {
            $result = Yii::$app->cache->get($cache_key);
        }
        if (!$this->enableCache || (is_bool($result) && !$result)) {
            $result = parent::count($q, $db);
            if ($this->enableCache) {
                Yii::$app->cache->set($cache_key, $result, $this->cacheDuration);
            }
        }
        return $result;
    }

    /**
     * @param $method
     * @param $params
     * @return string
     */
    protected function getCacheKey($method, $params)
    {
        $query = clone $this;
        if ($query->primaryModel !== null) {
            $query->primaryModel = $query->primaryModel->className() . '#' . json_encode($query->primaryModel->primaryKey);
        }
        return md5(serialize([
            $method,
            $query,
            $params
        ]));
    }
}
