<?php

namespace app\modules\article;

use Yii;

/**
 * article module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\article\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // initialize the module with the configuration loaded from config.php
        Yii::configure($this, require(__DIR__ . '/config.php'));
    }
}
