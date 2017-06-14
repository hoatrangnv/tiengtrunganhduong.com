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
?>
<div class="social-share">
    <div id="fb-like" class="fb-like" data-href="<?= $url ?>" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>
    <a class="twitter-share-button" href="https://twitter.com/intent/tweet">Tweet</a>
    <div class="g-plus" data-action="share"></div>
</div>

<style>
    .social-share {
        display: block;
        background: #fafafa;
        border-radius: 3px;
        padding: 0.4em;
        margin-top: 1em;
    }
    .social-share .fb-like {
        font-size: 0; /* Make fb, g+, twt lie in aline */
    }
</style>
