<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 6/11/2017
 * Time: 11:31 PM
 */
?>
<style>
    .fb-msg {
        position: fixed;
        z-index: 9999999;
        right: 1rem;
        bottom: 0;
    }
    .fb-msg,
    .fb-msg * {
        box-sizing: border-box !important;
        max-width: 100% !important;
    ]
    .fb-msg svg {
        display: inline-block;
    }
    .fb-msg-title {
        padding: 5px 10px;
        border-radius: 5px 5px 0 0;
        background: #3e7cf7;
        font-weight: bold;
        color: #fff;
        cursor: pointer;
    }
    .fb-msg-title * {
        vertical-align: middle;
    }
    .fb-msg .fb-msg-content {
        display: none;
    }
    .fb-msg.active .fb-msg-content {
        display: block;
    }
    @media screen and (max-width: 640px) {
        .fb-msg {
            right: 0.5rem;
        }
    }
</style>
<div class="fb-msg">
    <div class="fb-msg-title" onclick="this.parentNode.classList.toggle('active')">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="96 93 322 324"><path d="M257 93c-88.918 0-161 67.157-161 150 0 47.205 23.412 89.311 60 116.807V417l54.819-30.273C225.449 390.801 240.948 393 257 393c88.918 0 161-67.157 161-150S345.918 93 257 93zm16 202l-41-44-80 44 88-94 42 44 79-44-88 94z" fill="white"></path></svg>
        <?= Yii::t('app', 'Chat with us') ?>
    </div>
    <div class="fb-msg-content">
        <div class="fb-page" data-href="https://www.facebook.com/tiengtrunganhduong/"
             data-small-header="true"
             data-height="300"
             data-width="250"
             data-tabs="messages"
             data-adapt-container-width="false"
             data-hide-cover="true"
             data-show-facepile="false"
             data-show-posts="false">
        </div>
    </div>
</div>