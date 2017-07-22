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
 */
?>
<div id="root"></div>
<script type="text/babel">
    ReactDOM.render(
        <Quiz
            name="My quiz"
            introduction="Xin chao"
            image_src={<?= $quiz->image ? $quiz->image->getSource() : '"http://tiengtrunganhduong.com/images/201707/tu-vung-tieng-trung-chu-de-thu-cung/tu-vung-tieng-trung-chu-de-thu-cung.jpg"' ?>}
            login={fbLogin}
            quizInputGroups={<?= json_encode($quizInputGroups) ?>}
            quizParams={<?= json_encode($quizParams) ?>}
            quizCharacters={<?= json_encode($quizCharacters) ?>}
        />,
        document.getElementById("root")
    );
</script>
<div id="fb-root"></div>
<script>
    function fbLogin(callback) {
        FB.login(function(response) {
            if (response.authResponse) {
                console.log('Welcome!  Fetching your information.... ');
                FB.api('/me', function(response) {
                    console.log('Good to see you, ' + response.name + '.');
                    console.log(response);
                    var res = {};
                    res.charactersRealData = [response];
                    callback(res);
                });
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