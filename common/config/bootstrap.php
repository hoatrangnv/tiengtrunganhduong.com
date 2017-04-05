<?php
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('@images', dirname(dirname(__DIR__)) . '/frontend/web/images');

$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https://' : 'http://';
if (isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] != 'localhost') {
    Yii::setAlias('@frontendUrl', $protocol . $_SERVER['HTTP_HOST']);
    Yii::setAlias('@backendUrl', $protocol . $_SERVER['HTTP_HOST'] . '/backend');
    Yii::setAlias('@imagesUrl', $protocol . $_SERVER['HTTP_HOST'] . '/images');
} else {
    Yii::setAlias('@frontendUrl', $protocol . 'localhost/quyettran.com');
    Yii::setAlias('@backendUrl', $protocol . 'localhost/quyettran.com/backend');
    Yii::setAlias('@imagesUrl', $protocol . 'localhost/quyettran.com/images');
}
