<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 8/25/2018
 * Time: 3:24 PM
 */

namespace frontend\models;


class QuizHighScore extends \common\models\QuizHighScore
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}