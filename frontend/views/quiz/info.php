<?php
/**
 * Created by PhpStorm.
 * User: Quyet
 * Date: 6/9/2017
 * Time: 5:42 PM
 */

/**
 * @var \frontend\models\Quiz $model
 */

?>
<span class="info-item datetime">
    <i class="icon calendar-icon"></i>
    <span><?= $model->date() ?></span>
</span>
<span class="info-item views">
    <i class="icon eye-icon"></i>
    <span><?= Yii::t('app', '{0,number} plays', $model->views()) ?></span>
</span>
<span class="info-item comments">
    <i class="icon chat-icon"></i>
    <span><?= Yii::t('app', '{0,number} comments', $model->comments()) ?></span>
</span>

