<?php

namespace common\modules\quiz\baseModels;

use Yii;

/**
 * This is the model class for table "quiz".
 *
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property string $introduction
 * @property integer $duration
 * @property string $description
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keywords
 * @property integer $sort_order
 * @property integer $active
 * @property integer $visible
 * @property integer $doindex
 * @property integer $dofollow
 * @property integer $featured
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $publish_time
 * @property integer $creator_id
 * @property integer $updater_id
 * @property integer $image_id
 * @property integer $quiz_category_id
 *
 * @property User $creator
 * @property Image $image
 * @property QuizCategory $quizCategory
 * @property User $updater
 * @property QuizAlert[] $quizAlerts
 * @property QuizCharacter[] $quizCharacters
 * @property QuizInputGroup[] $quizInputGroups
 * @property QuizInputValidator[] $quizInputValidators
 * @property QuizObjectFilter[] $quizObjectFilters
 * @property QuizParam[] $quizParams
 * @property QuizResult[] $quizResults
 * @property QuizShape[] $quizShapes
 * @property QuizStyle[] $quizStyles
 */
class Quiz extends QuizBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'slug', 'create_time', 'update_time', 'publish_time', 'creator_id', 'updater_id'], 'required'],
            [['introduction'], 'string'],
            [['duration', 'sort_order', 'active', 'visible', 'doindex', 'dofollow', 'featured', 'create_time', 'update_time', 'publish_time', 'creator_id', 'updater_id', 'image_id', 'quiz_category_id'], 'integer'],
            [['name', 'slug', 'meta_title'], 'string', 'max' => 255],
            [['description', 'meta_description', 'meta_keywords'], 'string', 'max' => 511],
            [['name'], 'unique'],
            [['slug'], 'unique'],
            [['creator_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creator_id' => 'id'], 'except' => 'test'],
            [['image_id'], 'exist', 'skipOnError' => true, 'targetClass' => Image::className(), 'targetAttribute' => ['image_id' => 'id'], 'except' => 'test'],
            [['quiz_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuizCategory::className(), 'targetAttribute' => ['quiz_category_id' => 'id'], 'except' => 'test'],
            [['updater_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updater_id' => 'id'], 'except' => 'test'],
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
            'slug' => 'Slug',
            'introduction' => 'Introduction',
            'duration' => 'Duration',
            'description' => 'Description',
            'meta_title' => 'Meta Title',
            'meta_description' => 'Meta Description',
            'meta_keywords' => 'Meta Keywords',
            'sort_order' => 'Sort Order',
            'active' => 'Active',
            'visible' => 'Visible',
            'doindex' => 'Doindex',
            'dofollow' => 'Dofollow',
            'featured' => 'Featured',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'publish_time' => 'Publish Time',
            'creator_id' => 'Creator ID',
            'updater_id' => 'Updater ID',
            'image_id' => 'Image ID',
            'quiz_category_id' => 'Quiz Category ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreator()
    {
        return $this->hasOne(User::className(), ['id' => 'creator_id']);
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
    public function getQuizCategory()
    {
        return $this->hasOne(QuizCategory::className(), ['id' => 'quiz_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdater()
    {
        return $this->hasOne(User::className(), ['id' => 'updater_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizAlerts()
    {
        return $this->hasMany(QuizAlert::className(), ['quiz_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizCharacters()
    {
        return $this->hasMany(QuizCharacter::className(), ['quiz_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizInputGroups()
    {
        return $this->hasMany(QuizInputGroup::className(), ['quiz_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizInputValidators()
    {
        return $this->hasMany(QuizInputValidator::className(), ['quiz_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizObjectFilters()
    {
        return $this->hasMany(QuizObjectFilter::className(), ['quiz_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizParams()
    {
        return $this->hasMany(QuizParam::className(), ['quiz_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizResults()
    {
        return $this->hasMany(QuizResult::className(), ['quiz_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizShapes()
    {
        return $this->hasMany(QuizShape::className(), ['quiz_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizStyles()
    {
        return $this->hasMany(QuizStyle::className(), ['quiz_id' => 'id']);
    }
}
