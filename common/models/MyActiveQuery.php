<?php
namespace common\models;

use Yii;
use yii\db\ActiveQuery;
use yii\di\Instance;
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
class MyActiveQuery extends ActiveQuery
{
    public $enableCache = true;

    public $cacheDuration = 3600;

    public $publishTimeWrongNumber = 300;

    public $activeAttribute = 'active';

    public $publishTimeAttribute = 'publish_time';

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

    public function active()
    {
        return $this->andWhere([$this->activeAttribute => true]);
    }
    
    public function oneActive($db = null)
    {
        return $this->active()->one($db);
    }

    public function allActive($db = null)
    {
        return $this->active()->all($db);
    }
    
    public function countActive($q = '*', $db = null)
    {
        return $this->active()->count($q, $db);
    }
    
    public function published($wrong_number = null)
    {
        if ($wrong_number === null) {
            $wrong_number = $this->publishTimeWrongNumber;
        }

        $time = (int) round(time() / $wrong_number) * $wrong_number;
        
        return $this->active()->andWhere(['<=', $this->publishTimeAttribute, $time]);
    }
    
    public function onePublished($db = null)
    {
        return $this->published()->one($db);
    }
    
    public function allPublished($db = null)
    {
        return $this->published()->all($db);
    }
    
    public function countPublished($q = '*', $db = null)
    {
        return $this->published()->count($q, $db);
    }
    
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
    
    protected function getCacheKey($method, $params)
    {
        $query = clone $this;
        if ($query->primaryModel !== null) {
            $query->primaryModel = "{$query->primaryModel->className()}#{$query->primaryModel->primaryKey}";
        }
        return md5(serialize([
            $method,
            $query,
            $params
        ]));
    }
}
