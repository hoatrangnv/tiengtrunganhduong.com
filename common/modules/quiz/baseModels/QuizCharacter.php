<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz_character".
 *
 * @property integer $id
 * @property string $name
 * @property string $var_name
 * @property string $type
 * @property string $index
 * @property integer $task_order
 * @property integer $quiz_id
 *
 * @property Quiz $quiz
 * @property QuizCharacterDataFilter[] $quizCharacterDataFilters
 * @property QuizCharacterDataSorter[] $quizCharacterDataSorters
 * @property QuizCharacterMedium[] $quizCharacterMedia
 */
class QuizCharacter extends QuizBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_character';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'var_name', 'type', 'index', 'task_order', 'quiz_id'], 'required'],
            [['task_order', 'quiz_id'], 'integer'],
            [['name', 'var_name', 'type', 'index'], 'string', 'max' => 255],
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
            'var_name' => 'Var Name',
            'type' => 'Type',
            'index' => 'Index',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizCharacterDataFilters()
    {
        return $this->hasMany(QuizCharacterDataFilter::className(), ['quiz_character_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizCharacterDataSorters()
    {
        return $this->hasMany(QuizCharacterDataSorter::className(), ['quiz_character_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizCharacterMedia()
    {
        return $this->hasMany(QuizCharacterMedium::className(), ['quiz_character_id' => 'id']);
    }
}
