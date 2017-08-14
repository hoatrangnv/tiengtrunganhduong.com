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
    public function actionGetUserData()
    {
        $userID = Yii::$app->request->post('userID');
        $accessToken = Yii::$app->request->post('accessToken');
        $response = [
            'data' => [],
            'errorMsg' => '',
        ];

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
            $fbResponse = $fb->get("/$userID?fields=id,name,first_name,last_name,picture,gender", $accessToken);
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

    public function actionGetUserAvatar()
    {
        $userID = Yii::$app->request->get('userID');
        if (!$userID) {
            exit;
        }
        $width = Yii::$app->request->get('width', 0);
        $height = Yii::$app->request->get('height', 0);
        $contextOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
            ],
        ];

        $queryStr = '';
        if ($width > 0) {
            $queryStr = "width=$width";
        }
        if ($height > 0) {
            if ($queryStr) {
                $queryStr .= '&';
            }
            $queryStr .= "height=$height";
        }
        if ($queryStr) {
            $queryStr = "?$queryStr";
        }

        $image_data = file_get_contents(
            "https://graph.facebook.com/$userID/picture$queryStr",
            false,
            stream_context_create($contextOptions)
        );

        header("Content-Type: image/jpeg");
        imagejpeg(imagecreatefromstring($image_data));
    }

    public function actionCanvasImageToUrl()
    {
        if (!Yii::$app->request->isPost) {
            throw new \Exception;
        }
        if (($image = rawurldecode(Yii::$app->request->post('image'))) == null) {
            throw new \Exception;
        }
//        list($type, $data) = explode(';', $image);
//        list(, $data)      = explode(',', $data);
//        $data = base64_decode($data);
        $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $image));
        $image_name = uniqid(date('YmdHis_')) . '.jpg';
        file_put_contents(Yii::getAlias("@webroot/quiz-images/$image_name"), $data);
        return json_encode(['errorMsg' => '', 'data' => Yii::getAlias("@frontendUrl/quiz-images/$image_name")]);
    }
}