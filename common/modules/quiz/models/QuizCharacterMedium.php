<?php

namespace common\modules\quiz\models;

use Yii;

class QuizCharacterMedium extends \common\modules\quiz\baseModels\QuizCharacterMedium
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'var_name', 'type', 'index', 'global_exec_order', 'character_id'], 'required'],
            [['index', 'global_exec_order', 'character_id'], 'integer'],
            [['name', 'var_name', 'type'], 'string', 'max' => 255],
            [['character_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizCharacter::className(), 'targetAttribute' => ['character_id' => 'id'], 'except' => 'test'],
        ];
    }
}
