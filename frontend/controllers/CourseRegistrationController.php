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
use yii\bootstrap\ActiveForm;
use yii\web\Controller;
use yii\web\Response;

class CourseRegistrationController extends Controller
{
    const COURSE_LIST = [
        'HAN_NGU_1' => 'Hán Ngữ 1',
        'HAN_NGU_2' => 'Hán Ngữ 2',
        'HAN_NGU_3' => 'Hán Ngữ 3',
        'HAN_NGU_4' => 'Hán Ngữ 4',
        'HAN_NGU_5' => 'Hán Ngữ 5',
    ];

    public function actionIndex()
    {
        $this->layout = 'courseRegistration';
        // @TODO: Enable jQuery and yii
        Yii::$app->assetManager->bundles = [
            \yii\bootstrap\BootstrapAsset::class => [
                'css' => [],
            ],
        ];

        $model = new CourseRegistrationForm();
        $course_list = self::COURSE_LIST;
        $default_course = Yii::$app->request->get('default_course');
        if (!isset($course_list[$default_course])) {
            $default_course = '';
        }
        $model->course_name = $default_course;
        return $this->render('index', compact('model', 'course_list'));
    }

    public function actionAjaxSaveContact() {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $result = [];
        $model = new CourseRegistrationForm();
        $request = Yii::$app->request;
        if ($model->load($request->post())) {
            if ($model->validate()) {
                $ref = $request->post('ref');
                if ($ref !== null) {
                    $model->message .= "\n\n*Ref: $ref";
                }

                if ($model->saveContact()) {
                    $result['model'] = $model->attributes;
                } else {
                    $result['error'] = 'Không lưu được thông tin, vui lòng thử lại hoặc liên hệ trực tiếp qua hotline.';
                }
            } else {
                $result['error'] = $model->errors;
            }
        } else {
            $result['error'] = 'Không có dữ liệu nào được gửi lên, vui lòng thử lại hoặc liên hệ trực tiếp qua hotline.';
        }

        return $result;
    }

    public function actionAjaxValidateContact() {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $model = new CourseRegistrationForm();
        $request = Yii::$app->request;
        if ($request->isPost) {
            $model->load($request->post());
        }
        return ActiveForm::validate($model);
    }

    public function actionSuccess()
    {
        $this->layout = false;
        $course_list = self::COURSE_LIST;
        $name = Yii::$app->request->get('name', 'Nguyễn Văn A');
        $course_name_x = Yii::$app->request->get('course_name', 'Hán Ngữ');
        if (isset($course_list[$course_name_x])) {
            $course_name = $course_list[$course_name_x];
        } else {
            $course_name = 'Hán Ngữ';
        }
        return $this->render('success', compact('name', 'course_name'));
    }
}
