<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz_result".
 *
 * @property integer $id
 * @property string $name
 * @property string $type
 * @property string $title
 * @property string $description
 * @property string $content
 * @property integer $priority
 * @property integer $canvas_width
 * @property integer $canvas_height
 * @property integer $quiz_id
 *
 * @property QuizInputOptionToVotedResult[] $quizInputOptionToVotedResults
 * @property QuizInputOption[] $quizInputOptions
 * @property Quiz $quiz
 * @property QuizResultToCharacterMedium[] $quizResultToCharacterMedia
 * @property QuizCharacterMedium[] $quizCharacterMedia
 * @property QuizResultToShape[] $quizResultToShapes
 * @property QuizShape[] $quizShapes
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
            [['name', 'type', 'canvas_width', 'canvas_height', 'quiz_id'], 'required'],
            [['content'], 'string'],
            [['priority', 'canvas_width', 'canvas_height', 'quiz_id'], 'integer'],
            [['name', 'type', 'title'], 'string', 'max' => 255],
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
            'type' => 'Type',
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
    public function getQuizInputOptionToVotedResults()
    {
        return $this->hasMany(QuizInputOptionToVotedResult::className(), ['quiz_voted_result_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizInputOptions()
    {
        return $this->hasMany(QuizInputOption::className(), ['id' => 'quiz_input_option_id'])->viaTable('quiz_input_option_to_voted_result', ['quiz_voted_result_id' => 'id']);
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
    public function getQuizCharacterMedia()
    {
        return $this->hasMany(QuizCharacterMedium::className(), ['id' => 'quiz_character_medium_id'])->viaTable('quiz_result_to_character_medium', ['quiz_result_id' => 'id']);
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
    public function getQuizShapes()
    {
        return $this->hasMany(QuizShape::className(), ['id' => 'quiz_shape_id'])->viaTable('quiz_result_to_shape', ['quiz_result_id' => 'id']);
    }
}
