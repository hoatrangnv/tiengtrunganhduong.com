<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz_character_data_sorter".
 *
 * @property integer $id
 * @property string $name
 * @property integer $apply_order
 * @property string $arguments
 * @property integer $quiz_fn_id
 * @property integer $quiz_character_id
 *
 * @property QuizCharacter $quizCharacter
 * @property QuizFn $quizFn
 */
class QuizCharacterDataSorter extends QuizBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_character_data_sorter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'apply_order', 'arguments', 'quiz_fn_id', 'quiz_character_id'], 'required'],
            [['apply_order', 'quiz_fn_id', 'quiz_character_id'], 'integer'],
            [['name', 'arguments'], 'string', 'max' => 255],
            [['quiz_character_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizCharacter::className(), 'targetAttribute' => ['quiz_character_id' => 'id'], 'except' => 'test'],
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
            'apply_order' => 'Apply Order',
            'arguments' => 'Arguments',
            'quiz_fn_id' => 'Quiz Fn ID',
            'quiz_character_id' => 'Quiz Character ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizCharacter()
    {
        return $this->hasOne(QuizCharacter::className(), ['id' => 'quiz_character_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizFn()
    {
        return $this->hasOne(QuizFn::className(), ['id' => 'quiz_fn_id']);
    }
}
