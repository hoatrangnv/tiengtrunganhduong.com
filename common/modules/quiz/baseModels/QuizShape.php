<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz_shape".
 *
 * @property integer $id
 * @property string $name
 * @property string $text
 * @property integer $image_id
 * @property integer $quiz_id
 *
 * @property QuizResultToShape[] $quizResultToShapes
 * @property QuizResult[] $quizResults
 * @property Image $image
 * @property Quiz $quiz
 * @property QuizShapeToStyle[] $quizShapeToStyles
 * @property QuizStyle[] $quizStyles
 */
class QuizShape extends QuizBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_shape';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'quiz_id'], 'required'],
            [['image_id', 'quiz_id'], 'integer'],
            [['name', 'text'], 'string', 'max' => 255],
            [['image_id'], 'exist', 'skipOnError' => true, 'targetClass' => Image::className(), 'targetAttribute' => ['image_id' => 'id'], 'except' => 'test'],
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
            'text' => 'Text',
            'image_id' => 'Image ID',
            'quiz_id' => 'Quiz ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizResultToShapes()
    {
        return $this->hasMany(QuizResultToShape::className(), ['quiz_shape_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizResults()
    {
        return $this->hasMany(QuizResult::className(), ['id' => 'quiz_result_id'])->viaTable('quiz_result_to_shape', ['quiz_shape_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'image_id']);
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
    public function getQuizShapeToStyles()
    {
        return $this->hasMany(QuizShapeToStyle::className(), ['quiz_shape_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizStyles()
    {
        return $this->hasMany(QuizStyle::className(), ['id' => 'quiz_style_id'])->viaTable('quiz_shape_to_style', ['quiz_shape_id' => 'id']);
    }
}
