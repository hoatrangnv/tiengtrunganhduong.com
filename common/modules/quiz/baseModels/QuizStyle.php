<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz_style".
 *
 * @property integer $id
 * @property string $name
 * @property integer $z_index
 * @property integer $opacity
 * @property string $top
 * @property string $left
 * @property string $width
 * @property string $height
 * @property string $max_width
 * @property string $max_height
 * @property string $padding
 * @property string $background_color
 * @property string $border_color
 * @property string $border_width
 * @property string $border_radius
 * @property string $font
 * @property string $line_height
 * @property string $text_color
 * @property string $text_align
 * @property string $text_stroke_color
 * @property string $text_stroke_width
 * @property integer $quiz_id
 *
 * @property QuizCharacterMediumToStyle[] $characterMediumToStyles
 * @property QuizResultToCharacterMediumToStyle[] $resultToCharacterMediumToStyles
 * @property QuizResultToShapeToStyle[] $resultToShapeToStyles
 * @property QuizShapeToStyle[] $shapeToStyles
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
            [['z_index', 'opacity', 'quiz_id'], 'integer'],
            [['name', 'top', 'left', 'width', 'height', 'max_width', 'max_height', 'padding', 'background_color', 'border_color', 'border_width', 'border_radius', 'font', 'line_height', 'text_color', 'text_align', 'text_stroke_color', 'text_stroke_width'], 'string', 'max' => 255],
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
            'z_index' => 'Z Index',
            'opacity' => 'Opacity',
            'top' => 'Top',
            'left' => 'Left',
            'width' => 'Width',
            'height' => 'Height',
            'max_width' => 'Max Width',
            'max_height' => 'Max Height',
            'padding' => 'Padding',
            'background_color' => 'Background Color',
            'border_color' => 'Border Color',
            'border_width' => 'Border Width',
            'border_radius' => 'Border Radius',
            'font' => 'Font',
            'line_height' => 'Line Height',
            'text_color' => 'Text Color',
            'text_align' => 'Text Align',
            'text_stroke_color' => 'Text Stroke Color',
            'text_stroke_width' => 'Text Stroke Width',
            'quiz_id' => 'Quiz ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCharacterMediumToStyles()
    {
        return $this->hasMany(QuizCharacterMediumToStyle::className(), ['style_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResultToCharacterMediumToStyles()
    {
        return $this->hasMany(QuizResultToCharacterMediumToStyle::className(), ['style_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResultToShapeToStyles()
    {
        return $this->hasMany(QuizResultToShapeToStyle::className(), ['style_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShapeToStyles()
    {
        return $this->hasMany(QuizShapeToStyle::className(), ['style_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuiz()
    {
        return $this->hasOne(Quiz::className(), ['id' => 'quiz_id']);
    }
}
