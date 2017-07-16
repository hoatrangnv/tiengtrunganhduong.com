<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz_result".
 *
 * @property integer $id
 * @property string $name
 * @property string $title
 * @property string $description
 * @property string $content
 * @property integer $priority
 * @property integer $canvas_width
 * @property integer $canvas_height
 * @property integer $quiz_id
 *
 * @property QuizInputOptionToResultPoll[] $quizInputOptionToResultPolls
 * @property Quiz $quiz
 * @property QuizResultToCharacterMedium[] $quizResultToCharacterMedia
 * @property QuizResultToCharacterMediumFilter[] $quizResultToCharacterMediumFilters
 * @property QuizResultToShape[] $quizResultToShapes
 * @property QuizResultToShapeFilter[] $quizResultToShapeFilters
 */
class QuizResult extends QuizBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_result';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'quiz_id'], 'required'],
            [['content'], 'string'],
            [['priority', 'canvas_width', 'canvas_height', 'quiz_id'], 'integer'],
            [['name', 'title'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 511],
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
            'description' => 'Description',
            'content' => 'Content',
            'priority' => 'Priority',
            'canvas_width' => 'Canvas Width',
            'canvas_height' => 'Canvas Height',
            'quiz_id' => 'Quiz ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizInputOptionToResultPolls()
    {
        return $this->hasMany(QuizInputOptionToResultPoll::className(), ['quiz_result_id' => 'id']);
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
    public function getQuizResultToCharacterMedia()
    {
        return $this->hasMany(QuizResultToCharacterMedium::className(), ['quiz_result_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizResultToCharacterMediumFilters()
    {
        return $this->hasMany(QuizResultToCharacterMediumFilter::className(), ['quiz_result_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizResultToShapes()
    {
        return $this->hasMany(QuizResultToShape::className(), ['quiz_result_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizResultToShapeFilters()
    {
        return $this->hasMany(QuizResultToShapeFilter::className(), ['quiz_result_id' => 'id']);
    }
}
