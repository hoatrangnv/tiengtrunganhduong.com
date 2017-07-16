<?php

namespace common\modules\quiz\models;

use Yii;

class QuizInputGroup extends \common\modules\quiz\baseModels\QuizInputGroup
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'global_exec_order', 'quiz_id'], 'required'],
            [['global_exec_order', 'quiz_id'], 'integer'],
            [['name', 'title'], 'string', 'max' => 255],
            [['quiz_id'], 'exist', 'skipOnError' => true, 'targetClass' => Quiz::className(), 'targetAttribute' => ['quiz_id' => 'id'], 'except' => 'test'],
        ];
    }
}
