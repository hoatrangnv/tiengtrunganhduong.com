<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz_style".
 *
 * @property integer $id
 * @property string $name
 * @property string $z_index
 * @property string $opacity
 * @property string $top
 * @property string $left
 * @property string $width
 * @property string $height
 * @property string $max_width
 * @property string $max_height
 * @property string $min_width
 * @property string $min_height
 * @property string $padding
 * @property string $background_color
 * @property string $border_color
 * @property string $border_width
 * @property string $border_radius
 * @property string $line_height
 * @property string $text_color
 * @property string $text_align
 * @property string $text_stroke_color
 * @property string $text_stroke_width
 * @property integer $quiz_id
 * @property string $font_family
 * @property string $font_size
 * @property string $font_weight
 * @property string $font_style
 *
 * @property QuizCharacterMediumToStyle[] $quizCharacterMediumToStyles
 * @property QuizCharacterMedium[] $quizCharacterMedia
 * @property QuizShapeToStyle[] $quizShapeToStyles
 * @property QuizShape[] $quizShapes
 * @property Quiz $quiz
 */
class QuizStyle extends QuizBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_style';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['quiz_id'], 'integer'],
            [['name', 'z_index', 'opacity', 'top', 'left', 'width', 'height', 'max_width', 'max_height', 'min_width', 'min_height', 'padding', 'background_color', 'border_color', 'border_width', 'border_radius', 'line_height', 'text_color', 'text_align', 'text_stroke_color', 'text_stroke_width', 'font_family', 'font_size', 'font_weight', 'font_style'], 'string', 'max' => 255],
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
            'z_index' => 'Z Index',
            'opacity' => 'Opacity',
            'top' => 'Top',
            'left' => 'Left',
            'width' => 'Width',
            'height' => 'Height',
            'max_width' => 'Max Width',
            'max_height' => 'Max Height',
            'min_width' => 'Min Width',
            'min_height' => 'Min Height',
            'padding' => 'Padding',
            'background_color' => 'Background Color',
            'border_color' => 'Border Color',
            'border_width' => 'Border Width',
            'border_radius' => 'Border Radius',
            'line_height' => 'Line Height',
            'text_color' => 'Text Color',
            'text_align' => 'Text Align',
            'text_stroke_color' => 'Text Stroke Color',
            'text_stroke_width' => 'Text Stroke Width',
            'quiz_id' => 'Quiz ID',
            'font_family' => 'Font Family',
            'font_size' => 'Font Size',
            'font_weight' => 'Font Weight',
            'font_style' => 'Font Style',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizCharacterMediumToStyles()
    {
        return $this->hasMany(QuizCharacterMediumToStyle::className(), ['quiz_style_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizCharacterMedia()
    {
        return $this->hasMany(QuizCharacterMedium::className(), ['id' => 'quiz_character_medium_id'])->viaTable('quiz_character_medium_to_style', ['quiz_style_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizShapeToStyles()
    {
        return $this->hasMany(QuizShapeToStyle::className(), ['quiz_style_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizShapes()
    {
        return $this->hasMany(QuizShape::className(), ['id' => 'quiz_shape_id'])->viaTable('quiz_shape_to_style', ['quiz_style_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuiz()
    {
        return $this->hasOne(Quiz::className(), ['id' => 'quiz_id']);
    }
}
