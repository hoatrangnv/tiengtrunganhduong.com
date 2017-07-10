<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz_param".
 *
 * @property integer $id
 * @property string $name
 * @property string $var_name
 * @property string $value
 * @property integer $global_exec_order
 * @property integer $quiz_id
 *
 * @property Quiz $quiz
 */
class QuizParam extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_param';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'var_name', 'value', 'global_exec_order'], 'required'],
            [['value'], 'string'],
            [['global_exec_order', 'quiz_id'], 'integer'],
            [['name', 'var_name'], 'string', 'max' => 255],
            [['quiz_id'], 'exist', 'skipOnError' => true, 'targetClass' => Quiz::className(), 'targetAttribute' => ['quiz_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'var_name' => 'Var Name',
            'value' => 'Value',
            'global_exec_order' => 'Global Exec Order',
            'quiz_id' => 'Quiz ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuiz()
    {
        return $this->hasOne(Quiz::className(), ['id' => 'quiz_id']);
    }
}
