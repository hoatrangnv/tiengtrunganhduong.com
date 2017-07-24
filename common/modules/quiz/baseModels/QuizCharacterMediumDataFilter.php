<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz_character_medium_data_filter".
 *
 * @property integer $id
 * @property string $name
 * @property string $arguments
 * @property integer $quiz_fn_id
 * @property integer $quiz_character_medium_id
 *
 * @property QuizCharacterMedium $quizCharacterMedium
 * @property QuizFn $quizFn
 */
class QuizCharacterMediumDataFilter extends QuizBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_character_medium_data_filter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'arguments', 'quiz_fn_id', 'quiz_character_medium_id'], 'required'],
            [['quiz_fn_id', 'quiz_character_medium_id'], 'integer'],
            [['name', 'arguments'], 'string', 'max' => 255],
            [['quiz_character_medium_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizCharacterMedium::className(), 'targetAttribute' => ['quiz_character_medium_id' => 'id'], 'except' => 'test'],
            [['quiz_fn_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizFn::className(), 'targetAttribute' => ['quiz_fn_id' => 'id'], 'except' => 'test'],
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
            'arguments' => 'Arguments',
            'quiz_fn_id' => 'Quiz Fn ID',
            'quiz_character_medium_id' => 'Quiz Character Medium ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizCharacterMedium()
    {
        return $this->hasOne(QuizCharacterMedium::className(), ['id' => 'quiz_character_medium_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizFn()
    {
        return $this->hasOne(QuizFn::className(), ['id' => 'quiz_fn_id']);
    }
}
