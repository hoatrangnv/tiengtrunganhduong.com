<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 6/11/2017
 * Time: 11:24 PM
 */

/**
 * @var string url
 */
if (!isset($url)) {
    $url = \yii\helpers\Url::current([], true);
}
?>
<div class="social-share clr">
    <div class="social-share-item clr">
        <div id="fb-like" class="fb-like" data-href="<?= $url ?>" data-layout="button_count" data-size="small" data-action="like" data-show-faces="true" data-share="true"></div>
    </div>
    <div class="social-share-item clr">
        <a class="twitter-share-button" href="https://twitter.com/intent/tweet">Tweet</a>
    </div>
    <div class="social-share-item clr">
        <div class="g-plus" data-action="share"></div>
    </div>
</div>

<style>
    .social-share {
        display: block;
        background: #f8f8f8;
        border-radius: 3px;
        padding: 0.1em 0.3em;
        margin-top: 1em;
    }
    .social-share-item > * {
        display: block !important;
        float: left !important;
    }
    .social-share-item {
        display: inline-block;
    }
</style>
