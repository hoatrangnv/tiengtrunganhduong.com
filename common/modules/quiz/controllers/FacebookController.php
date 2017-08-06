<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 8/6/2017
 * Time: 11:47 PM
 */

namespace common\modules\quiz\controllers;

use Yii;
use yii\web\Controller;
use Facebook\FacebookResponse;
use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;

class FacebookController extends Controller
{
    public function actionGetUserData($userID, $accessToken)
    {
        $fb = new Facebook([
            'app_id' => Yii::$app->params['fb_app_id'],
            'app_secret' => Yii::$app->params['fb_app_secret'],
            'default_graph_version' => 'v2.2',
        ]);

        try {
            // Returns a `Facebook\FacebookResponse` object
            /**
             * @var $response FacebookResponse
             */
            $response = $fb->get("/$userID?fields=id,name,first_name,last_name,picture,gender", $accessToken);
        } catch(FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        $user = $response->getGraphUser();

        echo 'Name: ' . $user['name'];
    }
}