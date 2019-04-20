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
            <div>Hotline: <?= $phone ? $phone->value : '' ?></div>
        </div>
        <div class="social-networks">
            <a title="facebook" href="<?= ($item = SiteParam::findOneByName(SiteParam::FACEBOOK_URL)) ? $item->value : 'javascript:void(0)' ?>" target="_blank" rel="nofollow"><i class="icon facebook-icon"></i></a>
            <a title="twitter" href="<?= ($item = SiteParam::findOneByName(SiteParam::TWITTER_URL)) ? $item->value : 'javascript:void(0)' ?>" target="_blank" rel="nofollow"><i class="icon twitter-icon" ></i></a>
            <a title="youtube" href="<?= ($item = SiteParam::findOneByName(SiteParam::YOUTUBE_URL)) ? $item->value : 'javascript:void(0)' ?>" target="_blank" rel="nofollow"><i class="icon youtube-icon"></i></a>
        </div>
        <div>
            <a href="http://www.dmca.com/Protection/Status.aspx?ID=5a851896-94bd-4f2e-89fd-79369a67a3a0" title="DMCA.com Protection Status" class="dmca-badge">
                <img src="//images.dmca.com/Badges/dmca_protected_sml_120n.png?ID=5a851896-94bd-4f2e-89fd-79369a67a3a0" alt="DMCA.com Protection Status">
            </a>
            <script src="//images.dmca.com/Badges/DMCABadgeHelper.min.js"> </script>
        </div>
    </div>
</footer>
<?php
if ($this->context->screen !== 'large' && $phone) {
    ?>
    <div id="phonering-alo-phoneIcon" class="phonering-alo-phone phonering-alo-green phonering-alo-show">
        <div class="phonering-alo-ph-circle"></div>
        <div class="phonering-alo-ph-circle-fill"></div>
        <a class="phonering-alo-ph-img-circle" title="Liên hệ" href="tel:<?= $phone->value ?>">
            <div class="pps-btn-img"></div>
        </a>
    </div>
    <?php
}
?>
