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
<div class="social-share">
    <div id="fb-like" class="fb-like" data-href="<?= $url ?>" data-layout="button_count" data-action="like" data-size="<?= $size ?>" data-show-faces="true" data-share="true"></div>
    <a class="twitter-share-button" href="https://twitter.com/intent/tweet">Tweet</a>
    <div class="g-plus" data-action="share"></div>
</div>

<style>
    .social-share {
        display: inline-block;
        vertical-align: middle;
        background: #fafafa;
        border-radius: 3px;
        padding: 0.4em;
    }
    .social-share .fb-like {
        font-size: 0;
    }
</style>
