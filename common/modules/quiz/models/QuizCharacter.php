<?php

namespace common\modules\quiz\models;

use Yii;

class QuizCharacter extends \common\modules\quiz\baseModels\QuizCharacter
{
    public function rules()
    {
        return [
            [['name', 'var_name', 'type', 'index', 'global_exec_order', 'quiz_id'], 'required'],
            [['index', 'global_exec_order', 'quiz_id'], 'integer'],
            [['name', 'var_name', 'type'], 'string', 'max' => 255],
            [['quiz_id'], 'exist', 'skipOnError' => true, 'targetClass' => Quiz::className(), 'targetAttribute' => ['quiz_id' => 'id'], 'except' => 'test'],
        ];
    }
}
