<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 6/19/2017
 * Time: 2:08 AM
 */
use frontend\models\SiteParam;

?>
<footer class="wrap">
    <div class="container clr">
        <div>
            <h3 class="company-name">
                <a href="<?= Yii::$app->homeUrl ?>" title="<?= Yii::$app->name ?>">
                    <?= ($item = SiteParam::findOneByName(SiteParam::COMPANY_NAME)) ? $item->value : Yii::$app->name ?>
                </a>
            </h3>
        </div>
        <div>
            <div><?= Yii::t('app', 'Address') ?>: <?= ($item = SiteParam::findOneByName(SiteParam::ADDRESS)) ? $item->value : '' ?></div>
            <div>Email: <?= ($item = SiteParam::findOneByName(SiteParam::EMAIL)) ? $item->value : '' ?></div>
            <div>Hotline: <?= ($item = SiteParam::findOneByName(SiteParam::PHONE_NUMBER_LABELED)) ? $item->value : '' ?></div>
        </div>
        <div class="social-networks">
            <a title="facebook" href="<?= ($item = SiteParam::findOneByName(SiteParam::FACEBOOK_URL)) ? $item->value : '#' ?>" target="_blank" rel="nofollow"><i class="icon facebook-icon"></i></a>
            <a title="twitter" href="<?= ($item = SiteParam::findOneByName(SiteParam::TWITTER_URL)) ? $item->value : '#' ?>" target="_blank" rel="nofollow"><i class="icon twitter-icon" ></i></a>
            <a title="google plus" href="<?= ($item = SiteParam::findOneByName(SiteParam::GOOGLE_PLUS_URL)) ? $item->value : '#' ?>" target="_blank" rel="nofollow"><i class="icon google-plus-icon"></i></a>
            <a title="youtube" href="<?= ($item = SiteParam::findOneByName(SiteParam::YOUTUBE_URL)) ? $item->value : '#' ?>" target="_blank" rel="nofollow"><i class="icon youtube-icon"></i></a>
        </div>
    </div>
</footer>