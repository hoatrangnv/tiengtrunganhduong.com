<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 8/20/2017
 * Time: 2:03 AM
 */

namespace frontend\controllers;

use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\FacebookResponse;
use Facebook\Facebook;
use frontend\models\User;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class UserController extends Controller
{

    const COOKIE_EXPIRE_TIME = 864000;

    /*
     * for javascript only
     */
    public function actionLoginWithFacebook()
    {
//        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $response = [
            'data' => null,
            'errorMsg' => ''
        ];

        $fb = new Facebook([
            'app_id' => Yii::$app->params['facebook.appID'],
            'app_secret' => Yii::$app->params['facebook.appSecret'],
            'default_graph_version' => 'v2.10',
        ]);

        $helper = $fb->getJavaScriptHelper();

        try {
            $accessToken = $helper->getAccessToken();
            $userID = $helper->getUserId();
        } catch (FacebookResponseException $e) {
            // When Graph returns an error
            $response['errorMsg'] = 'Graph returned an error: ' . $e->getMessage();
        } catch (FacebookSDKException $e) {
            // When validation fails or other local issues
            $response['errorMsg'] =  'Facebook SDK returned an error: ' . $e->getMessage();
        }


        if (isset($accessToken, $userID)) {
            // Logged in
            $response['data'] = [
                'userID' => $userID,
                'accessToken' => $accessToken->getValue(),
                'info' => [
                    'name' => null,
                    'first_name' => null,
                    'last_name' => null,
                    'gender' => null,
                    'birthday' => null,
                ],
            ];

            // Returns a `Facebook\FacebookResponse` object
            /**
             * @var $response FacebookResponse
             */
            $fbResponse = $fb->get("/$userID?fields=id,name,first_name,last_name,gender,picture,email,birthday", $accessToken);
            $fbUser = $fbResponse->getGraphUser();

            $username = User::getUsernameFromFbUId($userID);
            $password = Yii::$app->security->generateRandomString();
            if ($user = User::findByUsername($username)) {
                $user->first_name = $fbUser->getFirstName();
                $user->last_name = $fbUser->getLastName();
                $user->gender = $fbUser->getGender();
                $user->picture_url = $fbUser->getPicture()->getUrl();
                $user->save();
                Yii::$app->user->login($user, self::COOKIE_EXPIRE_TIME);
            } else {
                $user = new User();
                $user->username = $username;
                $user->email = $fbUser->getEmail();
                if (!$user->email) {
                    $user->email = "$username@facebook.com";
                }
                $user->first_name = $fbUser->getFirstName();
                $user->last_name = $fbUser->getLastName();
                $user->gender = $fbUser->getGender();
                $user->picture_url = $fbUser->getPicture()->getUrl();
                $user->type = User::TYPE_FRONTEND;
                $user->status = User::STATUS_ACTIVE;
                $user->setPassword($password);
                $user->generateAuthKey();
                if ($user->save()) {
                    Yii::$app->user->login($user, self::COOKIE_EXPIRE_TIME);
                }
            }

            $response['data']['info'] = [
                'id' => $userID,
                'name' => $fbUser->getName(),
                'first_name' => $fbUser->getFirstName(),
                'last_name' => $fbUser->getLastName(),
                'gender' => $fbUser->getGender(),
                'birthday' => $fbUser->getBirthday(),
            ];

            // User is logged in!
            // You can redirect them to a members-only page.
            //header('Location: https://example.com/members.php');
        } else {
            $response['errorMsg'] =  'No cookie set or no OAuth data could be obtained from cookie.';
        }

        return json_encode($response);
    }

    public function actionGetFacebookData()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $userID = Yii::$app->request->post('userID');
        $accessToken = Yii::$app->request->post('accessToken');
        $response = [
            'data' => null,
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
            $fbResponse = $fb->get("/$userID?fields=id,name,first_name,last_name,gender,birthday", $accessToken);
            $user = $fbResponse->getGraphUser();

            $response['data'] = [
                'id' => $userID,
                'name' => $user->getName(),
                'first_name' => $user->getFirstName(),
                'last_name' => $user->getLastName(),
                'gender' => $user->getGender(),
                'birthday' => $user->getBirthday(),
            ];
        } catch(FacebookResponseException $e) {
            $response['errorMsg'] = 'Graph returned an error: ' . $e->getMessage() . "\nuserID= $userID, accessToken= $accessToken";
        } catch(FacebookSDKException $e) {
            $response['errorMsg'] = 'Facebook SDK returned an error: ' . $e->getMessage();
        }

        return $response;
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

    public function actionLogout() {
        Yii::$app->user->logout();
        return $this->redirect(Url::home());
    }

    public function actionLoginFacebook() {
        if (!session_id()) {
            session_start();
        }
//        $accessToken = Yii::$app->request->get('token', '');
        $fb = new Facebook([
            'app_id' => Yii::$app->params['facebook.appID'],
            'app_secret' => Yii::$app->params['facebook.appSecret'],
            'default_graph_version' => 'v2.10',
        ]);

        $helper = $fb->getRedirectLoginHelper();
        if (Yii::$app->request->get('state', '') != '' ) {
            $_SESSION['FBRLH_state']=Yii::$app->request->get('state');
        }
        $permissions = ['public_profile', 'email'];
        $loginUrl = $helper->getLoginUrl(Url::to(['user/login-facebook'], true), $permissions);

        $accessToken = $helper->getAccessToken();

        if (!$accessToken ) {
            return $this->redirect($loginUrl);
//                return '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';
//             return ['stt' => '0', 'msg' => 'invalid token', 'data' => ''];
        } else {
            try {
                // Get the \Facebook\GraphNodes\GraphUser object for the current user.
                // If you provided a 'default_access_token', the '{access-token}' is optional.
                $response = $fb->get('/me?fields=id,name,first_name,last_name,gender,picture,email', $accessToken);
            } catch (FacebookResponseException $e) {
                // When Graph returns an error
                throw new NotFoundHttpException($e->getMessage());
//                return ['stt' => '0', 'msg' => 'Graph returned an error: ' . $e->getMessage(), 'data' => ''];
            } catch (FacebookSDKException $e) {
                // When validation fails or other local issues
//                return ['stt' => '0', 'msg' => 'Graph returned an error: ' . $e->getMessage(), 'data' => ''];
                throw new NotFoundHttpException($e->getMessage());
            }


            $fbUser = $response->getGraphUser();
            $userID = $fbUser->getId();
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
                $user->email = $fbUser->getEmail();
                if (!$user->email) {
                    $user->email = "$username@facebook.com";
                }
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
//            Yii::$app->user->login($model);
            return $this->redirect(Url::home());
        }
    }
}