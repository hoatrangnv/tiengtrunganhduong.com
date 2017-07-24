<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz_alert".
 *
 * @property integer $id
 * @property string $name
 * @property string $title
 * @property string $message
 * @property string $type
 * @property integer $task_order
 * @property integer $quiz_id
 *
 * @property Quiz $quiz
 */
class QuizAlert extends QuizBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_alert';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'message', 'type', 'task_order', 'quiz_id'], 'required'],
            [['message'], 'string'],
            [['task_order', 'quiz_id'], 'integer'],
            [['name', 'title', 'type'], 'string', 'max' => 255],
            [['quiz_id'], 'exist', 'skipOnError' => true, 'targetClass' => Quiz::className(), 'targetAttribute' => ['quiz_id' => 'id'], 'except' => 'test'],
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
            'title' => 'Title',
            'message' => 'Message',
            'type' => 'Type',
            'task_order' => 'Task Order',
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
