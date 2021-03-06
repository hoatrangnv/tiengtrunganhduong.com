<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz_input_option".
 *
 * @property integer $id
 * @property string $value
 * @property string $content
 * @property integer $score
 * @property integer $correct
 * @property integer $case_sensitive
 * @property integer $common_duration_change
 * @property integer $group_duration_change
 * @property integer $common_countdown_delay_change
 * @property integer $group_countdown_delay_change
 * @property string $explanation
 * @property integer $sort_order
 * @property integer $quiz_input_id
 * @property integer $repeat_count
 *
 * @property QuizInput $quizInput
 * @property QuizInputOptionChecker[] $quizInputOptionCheckers
 * @property QuizInputOptionToVotedResult[] $quizInputOptionToVotedResults
 * @property QuizResult[] $quizVotedResults
 */
class QuizInputOption extends QuizBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_input_option';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content', 'explanation'], 'string'],
            [['score', 'correct', 'case_sensitive', 'common_duration_change', 'group_duration_change', 'common_countdown_delay_change', 'group_countdown_delay_change', 'sort_order', 'quiz_input_id', 'repeat_count'], 'integer'],
            [['quiz_input_id'], 'required'],
            [['value'], 'string', 'max' => 255],
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
            'value' => 'Value',
            'content' => 'Content',
            'score' => 'Score',
            'correct' => 'Correct',
            'case_sensitive' => 'Case Sensitive',
            'common_duration_change' => 'Common Duration Change',
            'group_duration_change' => 'Group Duration Change',
            'common_countdown_delay_change' => 'Common Countdown Delay Change',
            'group_countdown_delay_change' => 'Group Countdown Delay Change',
            'explanation' => 'Explanation',
            'sort_order' => 'Sort Order',
            'quiz_input_id' => 'Quiz Input ID',
            'repeat_count' => 'Repeat Count',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizInput()
    {
        return $this->hasOne(QuizInput::className(), ['id' => 'quiz_input_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizInputOptionCheckers()
    {
        return $this->hasMany(QuizInputOptionChecker::className(), ['quiz_input_option_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizInputOptionToVotedResults()
    {
        return $this->hasMany(QuizInputOptionToVotedResult::className(), ['quiz_input_option_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizVotedResults()
    {
        return $this->hasMany(QuizResult::className(), ['id' => 'quiz_voted_result_id'])->viaTable('quiz_input_option_to_voted_result', ['quiz_input_option_id' => 'id']);
    }
}
