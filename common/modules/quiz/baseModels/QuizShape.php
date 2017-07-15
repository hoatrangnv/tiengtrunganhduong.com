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
 * @property QuizResultToShape[] $resultToShapes
 * @property Image $image
 * @property Quiz $quiz
 * @property QuizShapeToStyle[] $shapeToStyles
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
            [['image_id'], 'exist', 'skipOnError' => true, 'targetClass' => Image::className(), 'targetAttribute' => ['image_id' => 'id']],
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
            'text' => 'Text',
            'image_id' => 'Image ID',
            'quiz_id' => 'Quiz ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResultToShapes()
    {
        return $this->hasMany(QuizResultToShape::className(), ['shape_id' => 'id']);
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
    public function getShapeToStyles()
    {
        return $this->hasMany(QuizShapeToStyle::className(), ['shape_id' => 'id']);
    }
}
