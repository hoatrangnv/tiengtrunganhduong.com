<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 3/20/2018
 * Time: 12:47 PM
 */

namespace frontend\controllers;


use frontend\models\CourseRegistrationForm;
use Yii;
use yii\web\Controller;

class CourseRegistrationController extends Controller
{
    public function actionIndex()
    {
        $this->layout = false;
        $model = new CourseRegistrationForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
//            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
            // @TODO: Saves contact instead of sending email
            if ($model->saveContact()) {
                Yii::$app->session->setFlash('success', 'Đăng ký thành công!');
            } else {
                Yii::$app->session->setFlash('error', 'Không thành công. Vui lòng kiểm tra lại thông tin và thử lại!');
            }

            return $this->refresh();
        } else {
            $course_list = [
                'HAN_NGU_1' => 'Hán Ngữ 1',
                'HAN_NGU_2' => 'Hán Ngữ 2',
                'HAN_NGU_3' => 'Hán Ngữ 3',
                'HAN_NGU_4' => 'Hán Ngữ 4',
                'HAN_NGU_5' => 'Hán Ngữ 5',
            ];
            return $this->render('index', compact('model', 'course_list'));
        }
    }
}