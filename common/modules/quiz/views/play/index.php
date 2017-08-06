<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 7/23/2017
 * Time: 3:29 AM
 */
\common\modules\quiz\QuizEditorAsset::register($this);
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
 */
?>
<div id="root"></div>
<script type="text/babel">
    "use strict";

    ReactDOM.render(
        <Quiz
            name={<?= json_encode($quiz->name) ?>}
            introduction={<?=json_encode($quiz->introduction) ?>}
            image_src={<?= json_encode($quiz->image ? $quiz->image->getSource() : '') ?>}
            login={fbLogin}
            requestCharacterRealData={requestUserData}
            input_answers_showing={<?= json_encode($quiz->input_answers_showing) ?>}
            quizInputGroups={<?= json_encode($quizInputGroups) ?>}
            quizParams={<?= json_encode($quizParams) ?>}
            quizCharacters={<?= json_encode($quizCharacters) ?>}
            quizObjectFilters={<?= json_encode($quizObjectFilters) ?>}
            quizResults={<?= json_encode($quizResults) ?>}
            quizAlerts={<?= json_encode($quizAlerts) ?>}
            quizShapes={<?= json_encode($quizShapes) ?>}
            quizInputValidators={<?= json_encode($quizInputValidators) ?>}
            quizStyles={<?= json_encode($quizStyles) ?>}
        />,
        document.getElementById("root")
    );
</script>
<script>
    var userID;
    var accessToken;
    function requestUserData(userType, mediumTypes, callback) {
        switch (userType) {
            case "Player":
                getUserData(userID, accessToken);
                break;
            case "PlayerFriend":
                break;
        }
    }
    function getUserData(userID, accessToken) {
        var fd = new FormData();
        fd.append("<?= Yii::$app->request->csrfParam ?>", "<?= Yii::$app->request->csrfToken ?>");
        fd.append("userID", userID);
        fd.append("accessToken", accessToken);
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "<?= \yii\helpers\Url::to(['/quiz/facebook/get-user-data']) ?>", true);
        xhr.onload = function() {
            if (this.status == 200) {
                var response = JSON.parse(this.response);
                console.log("user data", response);
//                if (response && !response.error_message) {
//                    user.logged = true;
//                    user.id = response.id;
//                    user.name = response.name;
//                    user.first_name = response.first_name;
//                    user.last_name = response.last_name;
//                    user.gender = response.gender || "female";
//                    user.image = "";
//                }
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