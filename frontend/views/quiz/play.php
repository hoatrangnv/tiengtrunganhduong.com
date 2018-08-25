<?php

/**
 * Created by PhpStorm.
 * User: User
 * Date: 7/23/2017
 * Time: 3:29 AM
 */
use yii\helpers\Url;
use common\models\UrlParam;
use common\modules\quiz\QuizPlayAsset;
use common\modules\quiz\LocalQuizPlayAsset;
use \frontend\models\Image;

if (Yii::$app->request->get('use_local_asset') == 1) {
    LocalQuizPlayAsset::register($this);
} else {
    QuizPlayAsset::register($this);
}

/**
 *
 * @var $quiz \frontend\models\Quiz
 *
 * @var $relatedItems \frontend\models\Quiz[]
 */
$this->title = $quiz->name;
$this->params['breadcrumbs'][] = $this->title;

?>
<style>
    .content-box {
        background: #fff;
        padding-bottom: 1rem;
    }
    .fb-like-container {
        text-align: center;
        margin-top: 1rem;
    }
    .fb-like-container > *,
    .fb-like-container > * > * {
        display: inline-block;
        vertical-align: middle;
    }
    .fb-like-container .tip-text {
        font-weight: bold;
        font-size: 1.1em;
    }
    #like-us-arrow {
        width: 2.2em;
        fill: #365899;
    }
</style>
<div class="content-box">
    <script>
        window.QuizPlayProps = <?= json_encode($quiz->getPlayProps()) ?>;
    </script>
    <?= $this->render('_playFrame') ?>
    <script>
        window.renderQuizPlay();
        window.getHighScoreResult(data => {
            if (data.length > 0) {
                window.QuizHighScoreContainer.innerHTML = window.renderHighScoreResultAsHtml(data);
            }
        }, <?= $quiz->id ?>, 10);
    </script>
    <?= $this->render('//layouts/fbSDK') ?>
    <div class="fb-like-container">
        <div class="nowrap">
            <span class="tip-text">Like us on facebook!</span>
        </div>
        <div class="nowrap">
            <!--<svg id="like-us-arrow" viewBox="0 0 200 90">
                <path d="M0 30h150 0v-30 0l50 45l-50 45v-30 0h-150 0 Z"></path>
            </svg>-->
            <div
                class="fb-like"
                data-href="https://www.facebook.com/trungtamtiengtrungvuive//"
                data-layout="button_count"
                data-action="like"
                data-size="small"
                data-show-faces="false"
                data-share="false"
            ></div>
        </div>
    </div>
</div>
<div class="content-box">
    <?= $this->render('//layouts/fbComment') ?>
</div>
<!--
<div class="grid-view g3 aspect-ratio __3x2">
    <ul>
        <?php
//        echo $this->render('items', [
//            'models' => $relatedItems,
//            'imagesSize' => '250x170'
//        ]);
        ?>
    </ul>
</div>
-->

<script>
    setTimeout(updateCounter, 3000);
    function updateCounter() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (xhttp.readyState === 4 && xhttp.status === 200) {
                console.log(xhttp.response);
            }
        };
        xhttp.open("POST", "<?= Url::to(['quiz/ajax-update-counter']) ?>");
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("<?=
            (Yii::$app->request->csrfParam . '=' . Yii::$app->request->csrfToken)
            . ('&' . UrlParam::FIELD . '=view_count')
            . ('&' . UrlParam::VALUE . '=1')
            . ('&' . UrlParam::SLUG . '=' . $quiz->slug)
            ?>");
    }
</script>
