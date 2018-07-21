<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 8/20/2017
 * Time: 2:03 AM
 */

namespace frontend\controllers;

use Facebook\Facebook;
use Facebook\FacebookResponse;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Exceptions\FacebookResponseException;

use frontend\models\SiteParam;
use frontend\models\User;
use Yii;
use yii\web\Controller;

class bak_UserController extends Controller
{
    public function actionLoginWithFacebook()
    {

        $fb = new Facebook([
            'app_id' => Yii::$app->params['facebook.appID'],
            'app_secret' => Yii::$app->params['facebook.appSecret'],
            'default_graph_version' => 'v2.2',
        ]);

        $helper = $fb->getJavaScriptHelper();

        try {
            $accessToken = $helper->getAccessToken();
            $userID = $helper->getUserId();
        } catch(FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        if (!isset($accessToken, $userID)) {
            echo 'No cookie set or no OAuth data could be obtained from cookie.';
            exit;
        }

        // Logged in
        echo json_encode([
            'userID' => $userID,
            'accessToken' => $accessToken->getValue(),
        ]);

//        $_SESSION['fb_access_token'] = (string) $accessToken;

        try {
            // Returns a `Facebook\FacebookResponse` object
            /**
             * @var $response FacebookResponse
             */
            $fbResponse = $fb->get("/$userID?fields=id,name,first_name,last_name,gender,picture,email", $accessToken);
        } catch(FacebookResponseException $e) {
//            $response['errorMsg'] = 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(FacebookSDKException $e) {
//            $response['errorMsg'] = 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        $fbUser = $fbResponse->getGraphUser();

//        $response['data'] = [
//            'name' => $user->getName(),
//            'first_name' => $user->getFirstName(),
//            'last_name' => $user->getLastName(),
//            'gender' => $user->getGender(),
//            'birthday' => $user->getBirthday(),
//        ];

        $username = User::getUsernameFromFbUId($userID);
        $password = Yii::$app->security->generateRandomString();
        if ($user = User::findByUsername($username)) {
            $user->first_name = $fbUser->getFirstName();
            $user->last_name = $fbUser->getLastName();
            $user->gender = $fbUser->getGender();
            $user->picture_url = $fbUser->getPicture()->getUrl();
            $user->save();
            Yii::$app->user->login($user);
        } else {
            $user = new User();
            $user->username = $username;
            $user->email = "$username@facebook.com";
            $user->first_name = $fbUser->getFirstName();
            $user->last_name = $fbUser->getLastName();
            $user->gender = $fbUser->getGender();
            $user->picture_url = $fbUser->getPicture()->getUrl();
            $user->type = User::TYPE_FRONTEND;
            $user->status = User::STATUS_ACTIVE;
            $user->setPassword($password);
            $user->generateAuthKey();
            if ($user->save()) {
                Yii::$app->user->login($user);
            }
        }

        // User is logged in!
        // You can redirect them to a members-only page.
        //header('Location: https://example.com/members.php');


    }

    public function actionGetFacebookData()
    {
        $userID = Yii::$app->request->post('userID');
        $accessToken = Yii::$app->request->post('accessToken');
        $response = [
            'data' => [],
            'errorMsg' => '',
        ];

        $fb = new Facebook([
            'app_id' => Yii::$app->params['facebook.appID'],
            'app_secret' => Yii::$app->params['facebook.appSecret'],
            'default_graph_version' => 'v2.2',
        ]);

        try {
            // Returns a `Facebook\FacebookResponse` object
            /**
             * @var $response FacebookResponse
             */
            $fbResponse = $fb->get("/$userID?fields=id,name,first_name,last_name,gender", $accessToken);
        } catch(FacebookResponseException $e) {
            $response['errorMsg'] = 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(FacebookSDKException $e) {
            $response['errorMsg'] = 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        $user = $fbResponse->getGraphUser();

        $response['data'] = [
            'name' => $user->getName(),
            'first_name' => $user->getFirstName(),
            'last_name' => $user->getLastName(),
            'gender' => $user->getGender(),
            'birthday' => $user->getBirthday(),
        ];

        echo json_encode($response);
    }

    public function actionGetFacebookAvatar()
    {
        $userID = Yii::$app->request->get('userID');
        if (!$userID) {
            exit;
        }
        $width = Yii::$app->request->get('width');
        $height = Yii::$app->request->get('height');
        $contextOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
            ],
        ];

        $queryStr = '';
        if (is_numeric($width) && $width > 0) {
            $queryStr = "width=$width";
        }
        if (is_numeric($height) && $height > 0) {
            if ($queryStr) {
                $queryStr .= '&';
            }
            $queryStr .= "height=$height";
        }
        if ($queryStr) {
            $queryStr = "?$queryStr";
        }

        $image_data = @file_get_contents(
            "https://graph.facebook.com/$userID/picture$queryStr",
            false,
            stream_context_create($contextOptions)
        );

        header("Content-Type: image/jpeg");

        if ($image_data) {
            imagejpeg(imagecreatefromstring($image_data));
        }

    }
}