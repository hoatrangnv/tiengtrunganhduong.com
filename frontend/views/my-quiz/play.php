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
if (Yii::$app->request->get('use_local_asset') == 1) {
    LocalQuizPlayAsset::register($this);
} else {
    QuizPlayAsset::register($this);
}

/**
 *
 * @var $quiz \common\modules\quiz\models\Quiz
 * @var $quizCharacters \common\modules\quiz\models\QuizCharacter[]
 * @var $quizInputGroups \common\modules\quiz\models\QuizInputGroup[]
 * @var $quizParams \common\modules\quiz\models\QuizParam[]
 * @var $quizObjectFilters \common\modules\quiz\models\QuizObjectFilter[]
 * @var $quizStyles \common\modules\quiz\models\QuizStyle[]
 * @var $quizShapes \common\modules\quiz\models\QuizShape[]
 * @var $quizResults \common\modules\quiz\models\QuizResult[]
 * @var $quizInputValidators \common\modules\quiz\models\QuizInputValidator[]
 * @var $quizAlerts \common\modules\quiz\models\QuizAlert[]
 *
 * @var $relatedItems \frontend\models\Quiz[]
 */

$this->title = $quiz->name;
$this->params['breadcrumbs'][] = $this->title;
?>
<h2 class="news-title"><?= $quiz->name ?></h2>
<article>
    <div class="news-info">
        <?= $this->render('info', ['model' => $quiz]) ?>
    </div>
    <?php
    if ($quiz->description) {
        ?>
        <div class="news-desc">
            <?= nl2br($quiz->description) ?>
        </div>
        <?php
    }
    ?>
    <div class="news-content fit-content content-popup-images">
        <div id="quiz-play-root"></div>
    </div>
</article>
<article>
    <?= $this->render('//layouts/likeShare') ?>
    <?= $this->render('//layouts/fbComment') ?>
</article>
<div class="related-news">
    <h3 class="title"><?= Yii::t('app', 'Related quizzes') ?></h3>
    <div class="content aspect-ratio __5x3">
        <?= $this->render('items', [
            'models' => $relatedItems,
            'imagesSize' => '100x60'
        ]) ?>
    </div>
</div>
<script>
    window.QuizPlayRoot = document.getElementById("quiz-play-root");
    window.QuizPlayProps = {
        name: <?= json_encode($quiz->name) ?>,
        introduction: <?=json_encode($quiz->introduction) ?>,
        image_src: <?= json_encode($quiz->image ? $quiz->image->getSource() : '') ?>,
        login: fbLogin,
        share: fbShare,
        exportCanvasImageAsDataURL: exportCanvasImageAsDataURL,
        requestCharacterRealData: requestUserData,
        input_answers_showing: <?= json_encode($quiz->input_answers_showing) ?>,
        quizInputGroups: <?= json_encode($quizInputGroups) ?>,
        quizParams: <?= json_encode($quizParams) ?>,
        quizCharacters: <?= json_encode($quizCharacters) ?>,
        quizObjectFilters: <?= json_encode($quizObjectFilters) ?>,
        quizResults: <?= json_encode($quizResults) ?>,
        quizAlerts: <?= json_encode($quizAlerts) ?>,
        quizShapes: <?= json_encode($quizShapes) ?>,
        quizInputValidators: <?= json_encode($quizInputValidators) ?>,
        quizStyles: <?= json_encode($quizStyles) ?>
    };
    //==============================================
    var userID;
    var accessToken;
    function requestUserData(userType, media, callback) {
        switch (userType) {
            case "Player":
                getUserData(userID, accessToken, function (userData) {
                    var mediaData = {};
                    var mediaLoaded = 0;
                    media.forEach(function (medium) {
                        switch (medium.type) {
                            case "Avatar":
                                mediaData.Avatar = [];
                                getUserAvatarData(
                                    userID,
                                    medium.width,
                                    medium.height,
                                    function (mediumData) {
                                        mediaData.Avatar.push(mediumData);
                                        mediaLoaded++;
                                    }
                                );
                                break;
                        }
                    });
                    var interval = setInterval(function () {
                        if (mediaLoaded == media.length) {
                            clearInterval(interval);
                            callback(userData, mediaData);
                        }
                    }, 10);
                });
                break;
            case "PlayerFriend":
                break;
        }
    }
    function getUserAvatarData(userID, width, height, callback) {
        callback({
            image_src:
                "<?= Url::to([
                    '/quiz/facebook/get-user-avatar',
                    'userID' => '__userID__',
                    'width' => '__width__',
                    'height' => '__height__'
                ]) ?>"
                    .split("__userID__").join(userID)
                    .split("__width__").join(width)
                    .split("__height__").join(height)
        });
    }
    function getUserData(userID, accessToken, callback) {
        var fd = new FormData();
        fd.append("<?= Yii::$app->request->csrfParam ?>", "<?= Yii::$app->request->csrfToken ?>");
        fd.append("userID", userID);
        fd.append("accessToken", accessToken);
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "<?= Url::to(['/quiz/facebook/get-user-data']) ?>", true);
        xhr.onload = function() {
            if (this.status == 200) {
                var response = JSON.parse(this.response);
                console.log("user data", response);
                if (response && !response.errorMsg) {
                    callback(response.data);
                }
            } else {

            }
        };
        xhr.upload.onprogress = function(event) {
        };
        xhr.send(fd);
    }
    function fbLogin(callback) {
        FB.login(function(response) {
            console.log("response", response);
            if (response.authResponse) {
                console.log('Welcome!  Fetching your information.... ');
                accessToken = response.authResponse.accessToken;
                userID = response.authResponse.userID;
                callback();
            } else {
                console.log('User cancelled login or did not fully authorize.');
            }
        });
    }
    /**
     *
     * @param {Object} data
     * @param {String} data.image
     * @param {String} data.title
     * @param {String} data.description
     * @param {Function} callback
     */
    function exportCanvasImageAsDataURL(data, callback) {
        var fd = new FormData();
        fd.append("<?= Yii::$app->request->csrfParam ?>", "<?= Yii::$app->request->csrfToken ?>");
        fd.append("image", data);
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "<?= Url::to(['/quiz/facebook/canvas-image-to-url']) ?>", true);
        xhr.onload = function() {
            if (this.status == 200) {
                var response = JSON.parse(this.response);
                if (response && !response.errorMsg) {
                    console.log(response.data);
                }
                callback({data: response.data, errorMsg: response.errorMsg});
            } else {
                callback(false);
            }
        };
        xhr.upload.onprogress = function(event) {
        };
        xhr.send(fd);

    }
    function fbShare(data, callback) {
        console.log(data);
        FB.ui({
            method: "share",
            display: "iframe",
            href: location.href,
            picture: data.imageURL,
            title: data.title,
            description: data.description,
            caption: <?= json_encode(Yii::$app->name) ?>
        }, function (response) {
            if (response && !response.error_message) {
                alert('Posting completed.');
            } else {
                alert('Error while posting.');
            }
        });
    }
    window.fbAsyncInit = function() {
        FB.init({
            appId      : '1793387650973425',
            cookie     : true,
            xfbml      : true,
            version    : 'v2.8'
        });
        FB.AppEvents.logPageView();
    };
    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
<script>
    setTimeout(updateCounter, 3000);
    function updateCounter() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (xhttp.readyState === 4 && xhttp.status === 200) {
                console.log(xhttp.response);
            }
        };
        xhttp.open("POST", "<?= Url::to(['article/ajax-update-counter']) ?>");
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("<?=
            (Yii::$app->request->csrfParam . '=' . Yii::$app->request->csrfToken)
            . ('&' . UrlParam::FIELD . '=view_count')
            . ('&' . UrlParam::VALUE . '=1')
            . ('&' . UrlParam::SLUG . '=' . $quiz->slug)
            ?>");
    }
</script>