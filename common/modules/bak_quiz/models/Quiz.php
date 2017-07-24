<?php

namespace common\modules\quiz\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

class Quiz extends \common\modules\quiz\baseModels\Quiz
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'creator_id',
                'updatedByAttribute' => 'updater_id',
            ],
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'create_time',
                'updatedAtAttribute' => 'update_time',
                'value' => time(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'slug', 'publish_time'], 'required'],
            [['sort_order', 'active', 'visible', 'doindex', 'dofollow', 'featured', 'publish_time', 'image_id', 'quiz_category_id'], 'integer'],
            [['name', 'slug', 'meta_title'], 'string', 'max' => 255],
            [['description', 'meta_description', 'meta_keywords'], 'string', 'max' => 511],
            [['name'], 'unique'],
            [['slug'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function modelConfig()
    {
        $modelConfig = parent::modelConfig();

        $modelConfig['attrs'][] = [
            'type' => 'multipleSelectBox',
            'name' => 'quiz_input_group_filter_ids',
            'label' => 'Quiz input group filters',
            'value' => [],
            'errorMsg' => '',
            'options' => '@list QuizFilter',
            'rules' => [],
        ];

        $modelConfig['attrs'][] = [
            'type' => 'multipleSelectBox',
            'name' => 'quiz_character_filter_ids',
            'label' => 'Quiz character filters',
            'value' => [],
            'errorMsg' => '',
            'options' => '@list QuizFilter',
            'rules' => [],
        ];

        $modelConfig['attrs'][] = [
            'type' => 'multipleSelectBox',
            'name' => 'quiz_result_filter_ids',
            'label' => 'Quiz result filters',
            'value' => [],
            'errorMsg' => '',
            'options' => '@list QuizFilter',
            'rules' => [],
        ];

        return $modelConfig;
    }
}
