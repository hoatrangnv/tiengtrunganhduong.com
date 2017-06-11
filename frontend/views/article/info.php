<?php
/**
 * Created by PhpStorm.
 * User: Quyet
 * Date: 6/9/2017
 * Time: 5:42 PM
 */

/**
 * @var \frontend\models\Article $model
 */

?>
<span class="info-item">
    <i class="icon calendar-icon"></i>
    <span><?= $model->date() ?></span>
</span>
<span class="info-item">
    <i class="icon eye-icon"></i>
    <span><?= Yii::t('app', '{0,number} views', $model->views()) ?></span>
</span>
<span class="info-item">
    <i class="icon chat-icon"></i>
    <span><?= Yii::t('app', '{0,number} comments', $model->comments()) ?></span>
</span>

