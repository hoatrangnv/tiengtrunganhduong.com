<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 6/19/2017
 * Time: 2:08 AM
 */
use frontend\models\SiteParam;

$phone = SiteParam::findOneByName(SiteParam::PHONE_NUMBER);
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
            <div>Hotline: <?= $phone ? $item->value : '' ?></div>
        </div>
        <div class="social-networks">
            <a title="facebook" href="<?= ($item = SiteParam::findOneByName(SiteParam::FACEBOOK_URL)) ? $item->value : '#' ?>" target="_blank" rel="nofollow"><i class="icon facebook-icon"></i></a>
            <a title="twitter" href="<?= ($item = SiteParam::findOneByName(SiteParam::TWITTER_URL)) ? $item->value : '#' ?>" target="_blank" rel="nofollow"><i class="icon twitter-icon" ></i></a>
            <a title="google plus" href="<?= ($item = SiteParam::findOneByName(SiteParam::GOOGLE_PLUS_URL)) ? $item->value : '#' ?>" target="_blank" rel="nofollow"><i class="icon google-plus-icon"></i></a>
            <a title="youtube" href="<?= ($item = SiteParam::findOneByName(SiteParam::YOUTUBE_URL)) ? $item->value : '#' ?>" target="_blank" rel="nofollow"><i class="icon youtube-icon"></i></a>
        </div>
        <div>
            <a href="http://www.dmca.com/Protection/Status.aspx?ID=5a851896-94bd-4f2e-89fd-79369a67a3a0" title="DMCA.com Protection Status" class="dmca-badge">
                <amp-img src="//images.dmca.com/Badges/dmca_protected_sml_120n.png?ID=5a851896-94bd-4f2e-89fd-79369a67a3a0" width="121" height="24" layout="responsive" alt="DMCA.com Protection Status">
            </a>
        </div>
    </div>
</footer>
<?php
if ($phone) {
    ?>
    <div id="phonering-alo-phoneIcon" class="phonering-alo-phone phonering-alo-green phonering-alo-show">
        <div class="phonering-alo-ph-circle"></div>
        <div class="phonering-alo-ph-circle-fill"></div>
        <div class="phonering-alo-ph-img-circle">
            <a class="pps-btn-img " title="Liên hệ" href="tel:<?= $phone->value ?>"></a>
        </div>
    </div>
    <?php
}
?>
