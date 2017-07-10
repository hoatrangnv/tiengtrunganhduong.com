<?php

namespace common\modules\quiz\models;

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
 * @property QuizInputOptionToResultPoll[] $inputOptionToResultPolls
 * @property Quiz $quiz
 * @property QuizResultToCharacterMedium[] $resultToCharacterMedia
 * @property QuizResultToCharacterMediumFilter[] $resultToCharacterMediumFilters
 * @property QuizResultToShape[] $resultToShapes
 * @property QuizResultToShapeFilter[] $resultToShapeFilters
 */
class QuizResult extends \yii\db\ActiveRecord
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
    public function getInputOptionToResultPolls()
    {
        return $this->hasMany(QuizInputOptionToResultPoll::className(), ['result_id' => 'id']);
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
    public function getResultToCharacterMedia()
    {
        return $this->hasMany(QuizResultToCharacterMedium::className(), ['result_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResultToCharacterMediumFilters()
    {
        return $this->hasMany(QuizResultToCharacterMediumFilter::className(), ['result_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResultToShapes()
    {
        return $this->hasMany(QuizResultToShape::className(), ['result_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResultToShapeFilters()
    {
        return $this->hasMany(QuizResultToShapeFilter::className(), ['result_id' => 'id']);
    }
}
