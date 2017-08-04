<?php

namespace common\modules\quiz\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

class Quiz extends \common\modules\quiz\baseModels\Quiz
{
    public static function modelConfig()
    {
        $modelConfig = parent::modelConfig();

        foreach ($modelConfig['attrs'] as &$attr) {
            $newAttr = $attr;
            switch ($newAttr['name']) {
                case 'input_answers_showing':
                    $newAttr['type'] = 'Select';
                    $newAttr['options'] = [
                        [
                            'value' => 'AfterInputGroup',
                            'label' => 'Sau mỗi nhóm câu hỏi',
                        ],
                        [
                            'value' => 'AfterResult',
                            'label' => 'Sau kết quả',
                        ],
                        [
                            'value' => 'OnSubmit',
                            'label' => 'Mỗi khi bấm submit câu hỏi hoặc nhóm câu hỏi',
                        ],
                        [
                            'value' => 'Never',
                            'label' => 'Không bao giờ',
                        ],
                    ];
                    break;
            }
            $attr = $newAttr;
        }

        return $modelConfig;
    }

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
            [['introduction'], 'string'],
            [['duration', 'sort_order', 'active', 'visible', 'doindex', 'dofollow', 'featured', 'image_id', 'quiz_category_id'], 'integer'],
            [['name', 'slug', 'meta_title'], 'string', 'max' => 255],
            [['description', 'meta_description', 'meta_keywords'], 'string', 'max' => 511],
            [['name'], 'unique'],
            [['slug'], 'unique'],
            ['publish_time', 'date', 'format' => 'php:' . self::TIMESTAMP_FORMAT]
        ];
    }

    const TIMESTAMP_FORMAT = 'Y-m-d H:i:s';

//    public function __construct(array $config = [])
//    {
//        // Init publish time for new record
//        if ($this->isNewRecord) {
//            $this->publish_time = date(self::TIMESTAMP_FORMAT, $this->getDefaultPublishTime());
//        }
//        parent::__construct($config);
//    }

    public function afterFind()
    {
        // Init publish time for record found
        $this->publish_time = date(self::TIMESTAMP_FORMAT, $this->publish_time);
        parent::afterFind();
    }

    public function beforeSave($insert)
    {
        if (!$this->publish_time) {
            $this->publish_time = $this->getDefaultPublishTime();
        } else {
            $this->publish_time = strtotime($this->publish_time);
        }
        return parent::beforeSave($insert);
    }

    public function getDefaultPublishTime()
    {
        // Round up ten minute (600s)
        return 600 * ceil(time() / 600);
    }

}
