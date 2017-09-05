<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz_input_image".
 *
 * @property integer $id
 * @property integer $sort_order
 * @property integer $quiz_input_id
 * @property integer $image_id
 *
 * @property Image $image
 * @property QuizInput $quizInput
 */
class QuizInputImage extends QuizBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_input_image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sort_order', 'quiz_input_id', 'image_id'], 'integer'],
            [['quiz_input_id', 'image_id'], 'required'],
            [['image_id'], 'exist', 'skipOnError' => true, 'targetClass' => Image::className(), 'targetAttribute' => ['image_id' => 'id'], 'except' => 'test'],
            [['quiz_input_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizInput::className(), 'targetAttribute' => ['quiz_input_id' => 'id'], 'except' => 'test'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sort_order' => 'Sort Order',
            'quiz_input_id' => 'Quiz Input ID',
            'image_id' => 'Image ID',
        ];
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
    public function getQuizInput()
    {
        return $this->hasOne(QuizInput::className(), ['id' => 'quiz_input_id']);
    }
}
