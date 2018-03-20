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
            $courses = [
                'Hán ngữ 1',
                'Hán ngữ 2',
                'Hán ngữ 3',
                'Hán ngữ 4',
                'Hán ngữ 5',
                'Hán ngữ 6',
                'Giao tiếp',
                'Học online',
            ];
            $course_list = array_combine($courses, $courses);
            return $this->render('index', compact('model', 'course_list'));
        }
    }
}