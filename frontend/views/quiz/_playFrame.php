<?php
/**
 * Created by PhpStorm.
 * User: Quyet
 * Date: 10/5/2017
 * Time: 3:11 PM
 */

use \yii\helpers\Url;
?>

<div id="quiz-play-root"></div>

<style>
    .quiz--loading-box--icon,
    .loading-icon {
        background-image: url("data:image/svg+xml,\
    <svg version='1.1' id='Layer_1' xmlns='http:%2F%2Fwww.w3.org%2F2000%2Fsvg' xmlns:xlink='http:%2F%2Fwww.w3.org%2F1999%2Fxlink' x='0px' y='0px' width='24px' height='30px' viewBox='0 0 24 30' style='enable-background:new 0 0 50 50;' xml:space='preserve'>\
    <rect x='0' y='10' width='4' height='10' fill='%233B5998' opacity='0.2'>\
    <animate attributeName='opacity' attributeType='XML' values='0.2; 1; .2' begin='0s' dur='0.6s' repeatCount='indefinite' %2F>\
    <animate attributeName='height' attributeType='XML' values='10; 20; 10' begin='0s' dur='0.6s' repeatCount='indefinite' %2F>\
    <animate attributeName='y' attributeType='XML' values='10; 5; 10' begin='0s' dur='0.6s' repeatCount='indefinite' %2F>\
    <%2Frect>\
    <rect x='8' y='10' width='4' height='10' fill='%233B5998'  opacity='0.2'>\
    <animate attributeName='opacity' attributeType='XML' values='0.2; 1; .2' begin='0.15s' dur='0.6s' repeatCount='indefinite' %2F>\
    <animate attributeName='height' attributeType='XML' values='10; 20; 10' begin='0.15s' dur='0.6s' repeatCount='indefinite' %2F>\
    <animate attributeName='y' attributeType='XML' values='10; 5; 10' begin='0.15s' dur='0.6s' repeatCount='indefinite' %2F>\
    <%2Frect>\
    <rect x='16' y='10' width='4' height='10' fill='%233B5998'  opacity='0.2'>\
    <animate attributeName='opacity' attributeType='XML' values='0.2; 1; .2' begin='0.3s' dur='0.6s' repeatCount='indefinite' %2F>\
    <animate attributeName='height' attributeType='XML' values='10; 20; 10' begin='0.3s' dur='0.6s' repeatCount='indefinite' %2F>\
    <animate attributeName='y' attributeType='XML' values='10; 5; 10' begin='0.3s' dur='0.6s' repeatCount='indefinite' %2F>\
    <%2Frect>\
    <%2Fsvg>\
    ");
    }
    .loading-icon {
        width: 20px;
        height: 20px;
    }
    .quiz-msg-overlay {
        display: block;
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        background: transparent;
        z-index: 100;
    }
    .quiz-msg-inner {
        text-align: center;
        width: 210px;
        margin: 50px auto 0;
        background: #fff;
        padding: 10px;
        border-radius: 3px;
        border: 1px solid #999;
        box-shadow: 0 1px 12px rgba(0,0,0,0.4);
        -webkit-box-shadow: 0 1px 12px rgba(0,0,0,0.4);
    }
    .quiz-msg-large {
        width: 350px;
    }
    .quiz-msg-inner a {
        color: royalblue;
        font-weight: bold;
    }
    .quiz-msg-inner a:hover {
        text-decoration: underline;
    }
    .quiz-msg-text {

    }
    .quiz-msg-inner .quiz--button--login {
        font-size: 1.2em;
        margin-top: 1em;
        cursor: pointer;
    }
    .quiz--button--login {
        font-size: 1.4em;
    }
    .quiz--button--login * {
        display: inline-block;
        vertical-align: middle;
    }
    .quiz--button--login:before {
        content: "";
        display: inline-block;
        vertical-align: middle;
        margin-right: 0.5em;
        background-position: center;
        background-repeat: no-repeat;
        background-size: contain;
        background-image: url('data:image/svg+xml;utf8,<svg xmlns="http:%2F%2Fwww.w3.org%2F2000%2Fsvg" viewBox="0 0 408.788 408.788"><path d="M353.7 0H55.088C24.665 0 .002 24.662.002 55.085V353.7c0 30.424 24.662 55.086 55.085 55.086h147.275l.25-146.078h-37.95c-4.932 0-8.935-3.988-8.954-8.92l-.182-47.087c-.02-4.958 3.996-8.988 8.955-8.988h37.883v-45.498c0-52.8 32.247-81.55 79.348-81.55h38.65c4.946 0 8.956 4.01 8.956 8.955v39.703c0 4.944-4.007 8.952-8.95 8.955l-23.72.01c-25.614 0-30.574 12.173-30.574 30.036v39.39h56.285c5.363 0 9.524 4.682 8.892 10.008l-5.582 47.087c-.534 4.505-4.355 7.9-8.892 7.9h-50.453l-.25 146.078h87.63c30.422 0 55.084-24.662 55.084-55.084V55.084C408.787 24.663 384.124 0 353.7 0z" fill="white"%2F><%2Fsvg>');
        width: 1.5em;
        height: 1.5em;
    }
    #quiz-play-root .quiz--button--share {
        background: none;
        border: none;
        padding: 0;
    }
    .quiz--container {
        max-width: 600px;
    }
    .quiz--markdown a {
        color: #06b;
    }
    .quiz--markdown a:hover {
        text-decoration: underline;
    }
    .quiz--markdown a * {
        display: inline;
        vertical-align: middle;
    }


    /**
     * Share and Send buttons
     */
    .fb-logo-icon {
        background-image: url('data:image/svg+xml;utf8,<svg xmlns="http:%2F%2Fwww.w3.org%2F2000%2Fsvg" viewBox="0 0 408.788 408.788"><path d="M353.7 0H55.088C24.665 0 .002 24.662.002 55.085V353.7c0 30.424 24.662 55.086 55.085 55.086h147.275l.25-146.078h-37.95c-4.932 0-8.935-3.988-8.954-8.92l-.182-47.087c-.02-4.958 3.996-8.988 8.955-8.988h37.883v-45.498c0-52.8 32.247-81.55 79.348-81.55h38.65c4.946 0 8.956 4.01 8.956 8.955v39.703c0 4.944-4.007 8.952-8.95 8.955l-23.72.01c-25.614 0-30.574 12.173-30.574 30.036v39.39h56.285c5.363 0 9.524 4.682 8.892 10.008l-5.582 47.087c-.534 4.505-4.355 7.9-8.892 7.9h-50.453l-.25 146.078h87.63c30.422 0 55.084-24.662 55.084-55.084V55.084C408.787 24.663 384.124 0 353.7 0z" fill="white"%2F><%2Fsvg>');
        width: 1.5em;
        height: 1.5em;
    }
    .fb-msg-icon {
        background-image: url('data:image/svg+xml;utf8,<svg xmlns="http:%2F%2Fwww.w3.org%2F2000%2Fsvg" width="24" height="24" viewBox="96 93 322 324"><path d="M257 93c-88.918 0-161 67.157-161 150 0 47.205 23.412 89.311 60 116.807V417l54.819-30.273C225.449 390.801 240.948 393 257 393c88.918 0 161-67.157 161-150S345.918 93 257 93zm16 202l-41-44-80 44 88-94 42 44 79-44-88 94z" fill="white"><%2Fpath><%2Fsvg>');
        width: 1.5em;
        height: 1.5em;
    }
    .fb-bt-inner-share,
    .fb-bt-inner-send {
        padding: 0.6rem;
        transition: all 100ms;
    }
    .fb-bt-inner-share > *,
    .fb-bt-inner-send > * {
        display: inline-block;
        vertical-align: middle;
    }
    .fb-bt-inner-share {
        background-color: #4169b7;
    }
    .fb-bt-inner-send {
        background-color: #4080FF;
    }
    .quiz--button--share:hover .fb-bt-inner-share {
        background-color: #365899;
    }
    .quiz--button--share:hover .fb-bt-inner-send {
        background-color: #3E7CF7;
    }
    .quiz--loading-overlay {
        background-color: rgba(255,255,255,0.8);
    }
    .quiz--loading-overlay--message {
        color: #000;
    }
    @media screen and (max-width: 400px) {
        .quiz--button--share {
            font-size: 1.2em;
        }
        .quiz--button--login {
            font-size: 1.2em;
        }
    }
</style>

<script>
    window.QuizPlayMessages = {
        "Start": "Bắt đầu",
        "Login": "Tiếp tục với Facebook",
        "Share": "Chia sẻ với bạn bè",
        "Wait for a minute": "Chờ chút nhé...",
        "Loading": "Đang tải...",
        "Processing": "Đang xử lý...",
        "Loading images for canvas-based questions": "Đang tải ảnh cho câu hỏi...",
        "Next": "Tiếp theo",
        "Try again": "Thử lại",
        "This is required": "Câu hỏi bắt buộc",
        "Please fulfill this word": "Vui lòng hoàn thành",
        "Common remaining time": "Thời gian (common) còn lại",
        "Group remaining time": "Thời gian (group) còn lại",
        "Total time": "Tổng thời gian",
        "All questions answering time": "Tổng thời gian trả lời các câu hỏi",
        "Closed questions answering time": "Tổng thời gian trả lời câu hỏi đóng",
        "Failed to load images": "Không tải được ảnh",
        "Failed to get sharing data": "Không chia sẻ được",
        "Wait for sharing data": "Đang chia sẻ...",
        "Loading layers for result canvas": "Đang tạo ảnh kết quả..."
    };
    window.QuizPlayRoot = document.getElementById("quiz-play-root");
    if (window.QuizPlayProps) {
        if ("undefined" == typeof window.QuizPlayProps.login) {
            window.QuizPlayProps.login = fbLogin;
        }
        if ("undefined" == typeof window.QuizPlayProps.shareButtons) {
            window.QuizPlayProps.shareButtons = {
                below: [
                    {
                        method: fbShare,
                        html: "<div class='fb-bt-inner-share'><i class='icon fb-logo-icon'></i> <span><?= Yii::t('app', 'Share with friends') ?></span></div>"
                    },
                    {
                        method: fbSend,
                        html: "<div class='fb-bt-inner-send'><i class='icon fb-msg-icon'></i></div>"
                    }
                ]
            };
        }
        if ("undefined" == typeof window.QuizPlayProps.requestCharacterRealData) {
            window.QuizPlayProps.requestCharacterRealData = requestUserData;
        }
        if ("undefined" == typeof window.QuizPlayProps.getSharingData) {
            window.QuizPlayProps.getSharingData = getSharingData;
        }
    }
    //==============================================
    var serverLoggedIn = <?= Yii::$app->user->isGuest ? 'false' : 'true' ?>;
    var quizCompleted = false;
    var cacheDuration = 3 * 86400 * 1000;
    var userID;
    var accessToken;
    var friendsData = [];
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
                            case "Post":
                                mediaData.Post = [];
                                getUserPostData(
                                    userID,
                                    function (mediumData) {
                                        console.log("Posts", mediumData);
                                        mediaData.Post = mediumData;
                                        mediaLoaded++;
                                    }
                                );
                                break;
                            case "Photo":
                                mediaData.Photo = [];
                                getUserPhotoData(
                                    userID,
                                    function (mediumData) {
                                        console.log("Photos", mediumData);
                                        mediaData.Photo = mediumData;
                                        mediaLoaded++;
                                    }
                                );
                                break;

                        }
                    });
                    var interval = setInterval(function () {
                        if (mediaLoaded == media.length) {
                            clearInterval(interval);
                            userData.media = mediaData;
                            callback([userData]);
                        }
                    }, 10);
                });
                break;
            case "PlayerFriend":
                var cacheKey = "quiz/user/__userID__/posts".split("__userID__").join(userID);

                var cachedPosts = getCachedData(cacheKey);

                var getFriendsDataFromPostsAndCallback = function (posts) {
                    /* handle the result */
                    var commentIntimateLevel = 3;
                    var likeIntimateLevel = 1;
                    var addFriend = function (thisFriend, intimateLevel) {
                        if (thisFriend.id == userID) {
                            return;
                        }
                        var existingFriend = friendsData.find(function (friend) {
                            return friend.id == thisFriend.id;
                        });
                        if (existingFriend) {
                            existingFriend.intimate_level += intimateLevel;
                        } else {
                            friendsData.push({
                                id: thisFriend.id,
                                name: thisFriend.name,
                                intimate_level: intimateLevel
                            });
                        }
                    };
                    posts.forEach(function (post) {
                        if (post.comments) {
                            post.comments.data.forEach(function (commentData) {
                                addFriend(commentData.from, commentIntimateLevel);
                            });
                        }
                        if (post.likes) {
                            post.likes.data.forEach(function (liker) {
                                addFriend(liker, likeIntimateLevel);
                            });
                        }
                    });
                    var tryCount = 0;
                    var tryCountMax = 1000;
                    var tryDelay = 10;
                    var totalMediaLoaded = 0;
                    var tryInterval = setInterval(function () {
                        tryCount++;
                        console.log(totalMediaLoaded, media.length, friendsData.length);
                        if (totalMediaLoaded == media.length * friendsData.length || tryCount == tryCountMax) {
                            clearInterval(tryInterval);
                            callback(friendsData);
                            console.log("friendsData", friendsData);
                        }
                    }, tryDelay);
                    friendsData.forEach(function (friend) {
                        var friendID = friend.id;
                        friend.media = {};
                        media.forEach(function (medium) {
                            switch (medium.type) {
                                case "Avatar":
                                    friend.media.Avatar = [];
                                    getUserAvatarData(
                                        friendID,
                                        medium.width,
                                        medium.height,
                                        function (mediumData) {
                                            friend.media.Avatar.push(mediumData);
                                            totalMediaLoaded++;
                                        }
                                    );
                                    break;
                            }
                        });
                        //                                getUserData(friendID, accessToken, function (friendData) {
                        //                                    var mediaData = {};
                        //                                    var mediaLoaded = 0;
                        //                                    media.forEach(function (medium) {
                        //                                        switch (medium.type) {
                        //                                            case "Avatar":
                        //                                                mediaData.Avatar = [];
                        //                                                getUserAvatarData(
                        //                                                    friendID,
                        //                                                    medium.width,
                        //                                                    medium.height,
                        //                                                    function (mediumData) {
                        //                                                        mediaData.Avatar.push(mediumData);
                        //                                                        mediaLoaded++;
                        //                                                    }
                        //                                                );
                        //                                                break;
                        //                                        }
                        //                                    });
                        //                                    var interval = setInterval(function () {
                        //                                        if (mediaLoaded == media.length) {
                        //                                            clearInterval(interval);
                        //                                            friendData.media = mediaData;
                        //                                            friendsData.push(friendData);
                        //                                        }
                        //                                    }, 10);
                        //                                });
                    });
                };

                if (cachedPosts && cachedPosts.length > 9) {
                    getFriendsDataFromPostsAndCallback(cachedPosts);
                } else {
                    var requestFriendsData = function () {
                        console.log("get posts data");
                        FB.api(
                            "/" + userID + "/posts?fields=comments,likes",
                            function (response) {
                                if (response && !response.error) {
                                    getFriendsDataFromPostsAndCallback(response.data);

                                    // TODO: Cache posts
                                    setCachedData(cacheKey, response.data);
                                } else {
                                    callback();
                                }
                            }
                        );
                    };
                    var checkingPerm = false;
                    var checkPermAndReRequestIfNotGranted = function () {
                        if (checkingPerm) {
                            return;
                        }
                        checkingPerm = true;
                        FB.api('/me/permissions', function (response) {
                            //                    { "data": [
                            //                        {
                            //                            "permission": "user_birthday",
                            //                            "status": "granted"
                            //                        },
                            //                        {
                            //                            "permission": "public_profile",
                            //                            "status": "granted"
                            //                        },
                            //                        {
                            //                            "permission": "email",
                            //                            "status": "declined"
                            //                        }
                            //                    ]}
                            var has_user_posts_perm = false;
                            console.log("response.data");
                            console.log(response.data);
                            response.data.forEach(function (item) {
                                console.log(item);
                                if ("user_posts" == item.permission && "granted" == item.status) {
                                    has_user_posts_perm = true;
                                }
                            });
                            console.log("has_user_posts_perm", has_user_posts_perm);
                            if (has_user_posts_perm) {
                                requestFriendsData();
                            } else {
                                var reLoginBtn = element(
                                    "button",
                                    "<?= Yii::t("app", "Continue with Facebook")?>",
                                    {"class": "quiz--button--login"}
                                );

                                var msgOverlay = element(
                                    "div",
                                    element(
                                        "div",
                                        [
                                            element(
                                                "p",
                                                "<?= Yii::t("app", "This quiz need permission to access your posts, continue? ")?>",
                                                {"class": "quiz-msg-text", "align": "justify"}),
                                            reLoginBtn
                                        ],
                                        {"class": "quiz-msg-inner quiz-msg-large"}
                                    ),
                                    {"class": "quiz-msg-overlay"}
                                );

                                QuizPlayRoot.appendChild(msgOverlay);

                                reLoginBtn.onclick = function () {
                                    FB.login(function (loginResponse) {
                                        if (msgOverlay.parentNode) {
                                            msgOverlay.parentNode.removeChild(msgOverlay);
                                        }
                                        checkingPerm = false;
                                        checkPermAndReRequestIfNotGranted();
                                    }, {scope: 'user_posts', auth_type: 'rerequest'});
                                };
                            }
                        });
                    };
                    checkPermAndReRequestIfNotGranted();
                }

                break;
        }
    }

    function getCachedData(key) {
        var cachedDataString = localStorage.getItem(key);
        if (cachedDataString) {
            var cachedData = JSON.parse(cachedDataString);
            var time = cachedData.time;
            var now = new Date().getTime();
            console.log("get cached data, now - time - dur = ", new Date().getTime() - time - cacheDuration);
            console.log("get cached data, now_to_string - time - dur = ", new Date().getTime().toString() - time - cacheDuration);
            if (now - time - cacheDuration > 0) {
                localStorage.removeItem(key);
            } else {
                return cachedData.value;
            }
        }
        return null;
    }

    function setCachedData(key, value) {
        var cachedData = {
            time: new Date().getTime(),
            value: value
        };
        console.log("set cached data, time= ", new Date().getTime(), "time_to_string=", new Date().getTime().toString());
        var cachedDataString = JSON.stringify(cachedData);
        localStorage.setItem(key, cachedDataString);
    }
    
    function getUserAvatarData(_userID, width, height, callback) {
        var server_image_src = "<?=
            Url::to([
                '/user/get-facebook-avatar',
                'userID' => '__userID__',
                'width' => '__width__',
                'height' => '__height__'
            ])
            ?>"
            .split("__userID__").join(_userID)
            .split("__width__").join(width)
            .split("__height__").join(height);

        var cacheKey = "quiz/user/__userID__/avatar/__width__x__height__"
            .split("__userID__").join(_userID)
            .split("__width__").join(width)
            .split("__height__").join(height);

        var image_src = getCachedData(cacheKey);

        if (image_src) {
            callback({
                image_src: image_src
            });
        } else {
            callback({
                image_src: server_image_src
            });

            // Cache image data
            var caching = setInterval(function () {
                if (quizCompleted) {
                    clearInterval(caching);
                    var image = new Image();
                    image.src = server_image_src;
                    image.addEventListener("load", function () {
                        var canvas = document.createElement("canvas");
                        var ctx = canvas.getContext("2d");
                        canvas.width = image.naturalWidth;
                        canvas.height = image.naturalHeight;
                        ctx.drawImage(image, 0, 0);
                        setCachedData(cacheKey, canvas.toDataURL("image/jpeg"));
                    });
                }
            }, 100);
        }

    }

    function getUserPhotoData(_userID, callback) {

    }

    function getUserPostData(_userID, callback) {
        var cacheKey = "quiz/user/__userID__/posts.171102".split("__userID__").join(_userID);

        var cachedPosts = getCachedData(cacheKey);

        if (cachedPosts) {
            callback(cachedPosts);
        } else {
            var requestFriendsData = function () {
                console.log("get posts data");
                FB.api(
                    "/" + userID + "/posts?limit=500&fields=message,description,caption,created_time,updated_time,comments.limit(1000).summary(true),likes.limit(1000).summary(true),reactions.limit(1000).summary(true)",
                    function (response) {
                        if (response && !response.error) {
                            var posts = [];
                            if (response.data instanceof Array) {
                                response.data.forEach(function (item) {
//                                    var post = {
//                                        message: item.message || "",
//                                        description: item.description || "",
//                                        caption: item.caption || "",
//                                        reactions: item.reactions ? item.reactions.data : [],
//                                        comments: item.comments ? item.comments.data : [],
//                                        likes: item.likes ? item.likes.data : [],
//                                        created_time: item.created_time,
//                                        updated_time: item.updated_time
//                                    };
                                    var post = item;
                                    posts.push(post);
                                });
                            }
                            callback(posts);

                            // TODO: Cache posts
                            setCachedData(cacheKey, posts);
                        } else {
                            callback();
                        }
                    }
                );
            };
            var checkingPerm = false;
            var checkPermAndReRequestIfNotGranted = function () {
                if (checkingPerm) {
                    return;
                }
                checkingPerm = true;
                FB.api('/me/permissions', function (response) {
                    var has_user_posts_perm = false;
                    console.log("response.data");
                    console.log(response.data);
                    response.data.forEach(function (item) {
                        console.log(item);
                        if ("user_posts" == item.permission && "granted" == item.status) {
                            has_user_posts_perm = true;
                        }
                    });
                    console.log("has_user_posts_perm", has_user_posts_perm);
                    if (has_user_posts_perm) {
                        requestFriendsData();
                    } else {
                        var reLoginBtn = element(
                            "button",
                            "<?= Yii::t("app", "Continue with Facebook")?>",
                            {"class": "quiz--button--login"}
                        );

                        var msgOverlay = element(
                            "div",
                            element(
                                "div",
                                [
                                    element(
                                        "p",
                                        "<?= Yii::t("app", "This quiz need permission to access your posts, continue? ")?>",
                                        {"class": "quiz-msg-text", "align": "justify"}),
                                    reLoginBtn
                                ],
                                {"class": "quiz-msg-inner quiz-msg-large"}
                            ),
                            {"class": "quiz-msg-overlay"}
                        );

                        QuizPlayRoot.appendChild(msgOverlay);

                        reLoginBtn.onclick = function () {
                            FB.login(function (loginResponse) {
                                if (msgOverlay.parentNode) {
                                    msgOverlay.parentNode.removeChild(msgOverlay);
                                }
                                checkingPerm = false;
                                checkPermAndReRequestIfNotGranted();
                            }, {scope: 'user_posts', auth_type: 'rerequest'});
                        };
                    }
                });
            };
            checkPermAndReRequestIfNotGranted();
        }
    }
    function getUserData(_userID, accessToken, callback) {
        var cacheKey = "quiz/user/__userID__/info"
            .split("__userID__").join(_userID);

        var data = getCachedData(cacheKey);

        if (data) {
            callback(data);
        } else {
            console.log("getUserData", _userID, accessToken);
            var fd = new FormData();
            fd.append("<?= Yii::$app->request->csrfParam ?>", "<?= Yii::$app->request->csrfToken ?>");
            fd.append("userID", _userID);
            fd.append("accessToken", accessToken);
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "<?= Url::to(['/user/get-facebook-data']) ?>", true);
            xhr.onload = function () {
                if (this.status == 200) {
                    var response = JSON.parse(this.response);
                    console.log("user data", response);
                    if (response && !response.errorMsg) {
                        callback(response.data);
                        setCachedData(cacheKey, response.data);
                    }
                } else {
                    alert("<?= Yii::t('app', 'Connection error! Please refresh this page and try again') ?>");
                }
            };
            xhr.upload.onprogress = function (event) {
            };
            xhr.send(fd);
        }

    }

    function ajaxServerLogin(callback) {
        var fd = new FormData();
        fd.append("<?= Yii::$app->request->csrfParam ?>", "<?= Yii::$app->request->csrfToken ?>");
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "<?= Url::to(['/user/login-with-facebook']) ?>", true);
        xhr.onload = function () {
            if (this.status == 200) {
                var response = JSON.parse(this.response);
                console.log("response", response);
                if (!response.errorMsg) {
                    // Callback to continue Quiz
//                        userID = response.data.userID;
//                        accessToken = response.data.accessToken;
                    console.log("userID, accessToken", userID, accessToken);
                    console.log("ajax server login userData", response.data);
                    var cacheKey = "quiz/user/__userID__/info"
                        .split("__userID__").join(userID);
                    if (response.data.info && response.data.info.name) {
                        setCachedData(cacheKey, response.data.info);
                    }
                    if ("function" == typeof callback) {
                        callback();
                    }
                } else {
                    alert("<?= Yii::t('app', 'Login error') ?>" + ": " + response.errorMsg);
                }
            } else {
                alert("<?= Yii::t('app', 'Connection error! Please refresh this page and try again') ?>");
            }
        };
        xhr.upload.onprogress = function (event) {
        };
        xhr.send(fd);
    }

    var fb_login_status = '';

    function fbLogin(callback) {
        console.log("fbLogin");
        console.log("fb_login_status", fb_login_status);
        if ("connected" == fb_login_status) {
            callback();
        } else {

            var loadingMsg = element(
                "p",
                "<?= Yii::t('app', 'Connecting to Facebook...')?>",
                {"class": "quiz-msg-text"}
            );

            var loadingSpinner = element("i", null, {"class": "icon loading-icon"});

            var loadingF5 = element(
                "p",
                [
                    "<?= Yii::t('app', 'Wait too long')?>, ",
                    element("a", "<?= Yii::t('app', 'Click here')?>", {"href": window.location.href})
                ]
            );

            var loadingInner = element(
                "div",
                [loadingSpinner, loadingMsg],
                {"class": "quiz-msg-inner"}
            );

            var loadingOverlay = element(
                "div",
                loadingInner,
                {"class": "quiz-msg-overlay"}
            );

            var loginBtn = element(
                "button",
                "<?= Yii::t('app', "Continue with Facebook")?>",
                {"class": "quiz--button--login"}
            );

            QuizPlayRoot.appendChild(loadingOverlay);

            var removeLoadingOverlay = function () {
                if (loadingOverlay.parentNode == QuizPlayRoot) {
                    QuizPlayRoot.removeChild(loadingOverlay);
                }
            };

            var tryCount = 0;

            var _fbLogin = function () {
                FB.login(function (response) {
                    console.log("FB login response", response);
                    removeLoadingOverlay();
                    if (response.authResponse) {
                        console.log('You are logged in and cookie set!');
                        // Login on server async to improve speed
                        accessToken = response.authResponse.accessToken;
                        userID = response.authResponse.userID;
                        callback();
                        ajaxServerLogin(function () {
                            console.log("Ajax server login response");
//                                removeLoadingOverlay();
//                                callback();
                        });
                    } else {
                        console.log('User cancelled login or did not fully authorize.');
                    }
                }, {scope: 'public_profile,email'});
            };

            var _considerLogin = function () {
                if ("connected" == fb_login_status) {
                    console.log("fb_login_status= connected");
                    removeLoadingOverlay();
                    callback();
                } else {
                    loadingMsg.innerHTML = "<?= Yii::t('app', "Logging you in")?>";
                    if (tryCount > 0) {
                        loginBtn.onclick = _fbLogin;
                        loadingInner.classList.add("quiz-msg-large");
                        loadingInner.removeChild(loadingSpinner);
                        loadingInner.appendChild(loginBtn);
                    } else {
                        _fbLogin();
                    }
                }
            };

            if (fb_login_status) {
                _considerLogin();
            } else {
                var tryLogin = setInterval(function () {
                    tryCount++;
                    console.log("try login " + tryCount);
                    if (fb_login_status) {
                        clearInterval(tryLogin);
                        _considerLogin();
                    } else if (tryCount == 300) {
                        loadingInner.classList.add("quiz-msg-large");
                        loadingInner.appendChild(loadingF5);
                    }
                }, 100);
            }
        }
    }

    window.checkFBLoginStatus = function () {
        console.log("Check login status");
        FB.getLoginStatus(function (response) {
            if (response.status === 'connected') {
                // the user is logged in and has authenticated your
                // app, and response.authResponse supplies
                // the user's ID, a valid access token, a signed
                // request, and the time the access token
                // and signed request each expire
                userID = response.authResponse.userID;
                accessToken = response.authResponse.accessToken;
                console.log("the user is logged in and has authenticated your app");

                if (!serverLoggedIn) {
                    ajaxServerLogin();
                }
            } else if (response.status === 'not_authorized') {
                // the user is logged in to Facebook,
                // but has not authenticated your app
                console.log("the user is logged in to Facebook, but has not authenticated your app");
            } else {
                // the user isn't logged in to Facebook.
                console.log("the user isn't logged in to Facebook");
            }
            fb_login_status = response.status;
        });
    };

    /**
     *
     * @param {Object} data
     * @param {String} data.image
     * @param {String} data.title
     * @param {String} data.description
     * @param {Function} callback
     * @param {HTMLElement} overlay
     * @param {HTMLElement} message
     */
    function getSharingData(data, callback, overlay, message) {
        var fd = new FormData();
        fd.append("<?= Yii::$app->request->csrfParam ?>", "<?= Yii::$app->request->csrfToken ?>");
        fd.append("slug", window.QuizPlayProps ? window.QuizPlayProps.slug : '');
        fd.append("title", data.title);
        fd.append("description", data.description);
        fd.append("image", data.canvas.toDataURL("image/jpeg", 0.8));
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "<?= Url::to(['/quiz/get-sharing-data']) ?>", true);
        xhr.onload = function () {
            if (this.status == 200) {
                var response = JSON.parse(this.response);
                if (response && !response.errorMsg) {
                    console.log(response.data);
                    callback({data: response.data, errorMsg: response.errorMsg});
                    quizCompleted = true;
                } else {
                    callback(false);
                }
            } else {
                callback(false);
            }
        };
        var percentElm = element("span");
        message.appendChild(percentElm);
        xhr.upload.onprogress = function (event) {
//            console.log(event.lengthComputable);
//            console.log(event.total);
//            console.log(event.loaded);
//            if (event.total == event.loaded) {
//                console.log("loaded 100%");
//            }
            var k =  event.loaded / event.total;
            var opacity = 0.5 + 0.3 * (1 - k);
            var percent = Math.round(99 * k);
            if (!isNaN(opacity)) {
                overlay.style.backgroundColor = "rgba(255,255,255," + opacity + ")";
                percentElm.innerHTML = " (" + percent + "%)";
            }
        };
        xhr.upload.onloadend = function(pe) {
            console.log(event.lengthComputable);
            console.log(event.total);
            console.log(event.loaded);
        };
        xhr.send(fd);
    }
    function fbShare(data, callback) {
        FB.ui({
                method: "share",
                display: isMobile() ? "touch" : "popup",
                href: data.url,
                picture: data.image_url,
                title: data.title || (window.QuizPlayProps ? window.QuizPlayProps.name : ''),
                description: data.description || (window.QuizPlayProps ? window.QuizPlayProps.description : ''),
                caption: <?= json_encode(Yii::$app->name) ?>,
                hashtag: "#tiengtrunganhduong"
            }, // callback
            function (response) {
                if (response && !response.error_message) {
                    console.log('Posting completed.');
                } else {
                    console.log('Error while posting.');
                }
            });
    }

    function fbSend(data, callback) {
        if (isMobile()) {
            location.href = ("fb-messenger://share?link=" + data.url
            + "&app_id=<?= Yii::$app->params['facebook.appID'] ?>");
        } else {
            FB.ui({
                method: "send",
                display: "popup",
                link: data.url
            });
        }
    }

    function element(nodeName, content, attributes) {
        var node = document.createElement(nodeName);
        var append = function (t) {
            if ("string" == typeof t) {
                node.innerHTML += t;
            } else if (t instanceof HTMLElement) {
                node.appendChild(t);
            }
        };
        if (content instanceof Array) {
            content.forEach(function (item) {
                append(item);
            });
        } else {
            append(content);
        }
        if (attributes) {
            var attrName;
            for (attrName in attributes) {
                if (attributes.hasOwnProperty(attrName)) {
                    node.setAttribute(attrName, attributes[attrName])
                }
            }
        }
        return node;
    }

    function isMobile() {
        return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    }
</script>
