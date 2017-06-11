<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 6/11/2017
 * Time: 11:24 PM
 */

/**
 * @var string url
 * @var string size
 */
if (!isset($url)) {
    $url = \yii\helpers\Url::current([], true);
}
if (!isset($size)) {
    $size = 'small';
}
?>
<div id="fb-like" class="fb-like" data-href="<?= $url ?>" data-layout="button_count" data-action="like" data-size="<?= $size ?>" data-show-faces="true" data-share="true"></div>
