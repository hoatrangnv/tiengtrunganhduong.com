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
<div class="content-box fit-content">
    <div id="quiz-play-root"></div>
</div>
<div class="content-box">
    <?= $this->render('//layouts/likeShare') ?>
    <?= $this->render('//layouts/fbComment') ?>
</div>
<div>
    <div class="content aspect-ratio __5x3">
        <?= $this->render('items', [
            'models' => $relatedItems,
            'imagesSize' => '100x60'
        ]) ?>
    </div>
</div>
<script>
    window.QuizPlayMessages = {
        "Start": "Bắt đầu",
        "Login": "Đăng nhập để bắt đầu",
        "Share": "Chia sẻ với bạn bè",
        "Wait for minute": "Chờ một chút nhé",
        "Loading": "Đang tải",
        "Next": "Tiếp theo",
        "Common remaining time": "Thời gian còn lại",
        "Group remaining time": "Thời gian còn lại",
        "Total time": "Thời gian",
        "All questions answering time": "Thời gian trả lời câu hỏi",
        "Closed questions answering time": "Thời gian trả lời câu hỏi tính điểm"
    };
    window.QuizPlayRoot = document.getElementById("quiz-play-root");
    window.QuizPlayProps = {
        name: <?= json_encode($quiz->name) ?>,
        introduction: <?=json_encode($quiz->introduction) ?>,
        image_src: <?= json_encode($quiz->image ? $quiz->image->getSource() : '') ?>,
        duration: <?= json_encode($quiz->duration) ?>,
        countdown_delay: <?= json_encode($quiz->countdown_delay) ?>,
        timeout_handling: <?= json_encode($quiz->timeout_handling) ?>,
        showed_stopwatches: <?= $quiz->showed_stopwatches ? $quiz->showed_stopwatches : '[]' ?>,
        input_answers_showing: <?= json_encode($quiz->input_answers_showing) ?>,
        quizInputGroups: <?= json_encode($quizInputGroups) ?>,
        quizParams: <?= json_encode($quizParams) ?>,
        quizCharacters: <?= json_encode($quizCharacters) ?>,
        quizObjectFilters: <?= json_encode($quizObjectFilters) ?>,
        quizResults: <?= json_encode($quizResults) ?>,
        quizAlerts: <?= json_encode($quizAlerts) ?>,
        quizShapes: <?= json_encode($quizShapes) ?>,
        quizInputValidators: <?= json_encode($quizInputValidators) ?>,
        quizStyles: <?= json_encode($quizStyles) ?>,
        login: fbLogin,
        share: fbShare,
        getSharingData: getSharingData,
        requestCharacterRealData: requestUserData
    };
    //==============================================
    window.fbAsyncInit = function() {
        FB.init({
            appId      : '1793387650973425',
            cookie     : true,
            xfbml      : true,
            version    : 'v2.5'
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
                    '/user/get-facebook-avatar',
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
        xhr.open("POST", "<?= Url::to(['/user/get-facebook-data']) ?>", true);
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
    function ajaxServerLogin(callback) {
            var fd = new FormData();
            fd.append("<?= Yii::$app->request->csrfParam ?>", "<?= Yii::$app->request->csrfToken ?>");
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "<?= Url::to(['/user/login-with-facebook']) ?>", true);
            xhr.onload = function() {
                if (this.status == 200) {
                    var response2 = JSON.parse(this.response);
                    console.log("response2", response2);
                    // Callback to continue Quiz
                    accessToken = response2.accessToken;
                    userID = response2.userID;
                    callback();
                } else {

                }
            };
            xhr.upload.onprogress = function(event) {
            };
            xhr.send(fd);
    }
    function fbLogin(callback) {
        if (userID && accessToken) {
            callback();
        } else {
            FB.login(function(response) {
                if (response.authResponse) {
                    console.log('You are logged in and cookie set!');
                    // Create new account or login for this user on our server
                    // Now you can redirect the user or do an AJAX request to
                    // a PHP script that grabs the signed request from the cookie.
                    ajaxServerLogin(callback);
                } else {
                    console.log('User cancelled login or did not fully authorize.');
                }
            });
        }

//        FB.login(function(response) {
//            console.log("response", response);
//            if (response.authResponse) {
//                console.log('Welcome! Fetching your information.... ');
//                accessToken = response.authResponse.accessToken;
//                userID = response.authResponse.userID;
//                callback();
//            } else {
//                console.log('User cancelled login or did not fully authorize.');
//            }
//        });
    }
    window.addEventListener("load", function () {
        FB.getLoginStatus(function(response) {
            if (response.status === 'connected') {
                // the user is logged in and has authenticated your
                // app, and response.authResponse supplies
                // the user's ID, a valid access token, a signed
                // request, and the time the access token
                // and signed request each expire
                userID = response.authResponse.userID;
                accessToken = response.authResponse.accessToken;
            } else if (response.status === 'not_authorized') {
                // the user is logged in to Facebook,
                // but has not authenticated your app
            } else {
                // the user isn't logged in to Facebook.
            }
        });
    });

    /**
     *
     * @param {Object} data
     * @param {String} data.image
     * @param {String} data.title
     * @param {String} data.description
     * @param {Function} callback
     */
    function getSharingData(data, callback) {
        var fd = new FormData();
        fd.append("<?= Yii::$app->request->csrfParam ?>", "<?= Yii::$app->request->csrfToken ?>");
        fd.append("slug", <?= json_encode($quiz->slug) ?>);
        fd.append("title", data.title);
        fd.append("description", data.description);
        fd.append("image", data.image);
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "<?= Url::to(['/quiz/get-sharing-data']) ?>", true);
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
        console.log("sharing data", data);
        FB.ui({
                method: "share",
                display: "popup",
                href: data.url,
                picture: data.image_url,
                title: data.title || <?= json_encode($quiz->name) ?>,
                description: data.description || <?= json_encode($quiz->description) ?>,
                caption: <?= json_encode(Yii::$app->name) ?>
            },   // callback
            function(response) {
                if (response && !response.error_message) {
                    console.log('Posting completed.');
                } else {
                    console.log('Error while posting.');
                }
            });
    }
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