<?php
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('@images', dirname(dirname(__DIR__)) . '/frontend/web/images');

if ($_SERVER['HTTP_HOST'] == 'localhost') {
    Yii::setAlias('@frontendUrl', '//localhost/quyettran.com/frontend/web');
    Yii::setAlias('@backendUrl', '//localhost/quyettran.com/backend/web');
    Yii::setAlias('@imagesUrl', '//localhost/quyettran.com/frontend/web/images');
} else {
    Yii::setAlias('@frontendUrl', $_SERVER['HTTP_HOST']);
    Yii::setAlias('@backendUrl', $_SERVER['HTTP_HOST'] . '/backend');
    Yii::setAlias('@imagesUrl', $_SERVER['HTTP_HOST'] . '/images');
}
