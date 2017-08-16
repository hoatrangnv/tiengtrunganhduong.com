<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 7/23/2017
 * Time: 3:28 AM
 */

namespace common\modules\quiz\controllers;

use common\modules\quiz\models\Quiz;
use yii\web\NotFoundHttpException;

class PlayController extends BaseController
{
    public $layout = '@quiz/views/layouts/antd';

    public function actionIndex($id)
    {
        $quiz = $this->findModel($id);

        return $this->render('index', $quiz->getPlayData());
    }

    /**
     * Finds the Quiz model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Quiz the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Quiz::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}