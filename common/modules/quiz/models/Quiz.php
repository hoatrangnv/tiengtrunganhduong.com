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
//                        [
//                            'value' => 'AfterInputGroup',
//                            'label' => 'Sau mỗi nhóm câu hỏi',
//                        ],
//                        [
//                            'value' => 'AfterResult',
//                            'label' => 'Sau kết quả',
//                        ],
                        [
                            'value' => 'OnSubmit',
                            'label' => 'Mỗi khi bấm submit câu trả lời',
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
            [['name', 'slug', 'meta_title', 'input_answers_showing'], 'string', 'max' => 255],
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

    /**
     * @return array
     */
    public function getPlayData()
    {
        $quiz = $this;
        $quizCharacters = $quiz->quizCharacters;
        $quizInputGroups = $quiz->quizInputGroups;
        $quizParams = $quiz->quizParams;
        $quizObjectFilters = $quiz->quizObjectFilters;
        $quizAlerts = $quiz->quizAlerts;
        $quizResults = $quiz->quizResults;
        $quizShapes = $quiz->quizShapes;
        $quizInputValidators = $quiz->quizInputValidators;
        $quizStyles = $quiz->quizStyles;

        $_quizInputGroups = array_map(function ($item) {
            /**
             * @var $item QuizInputGroup
             */
            $attrs = $item->attributes;
            $quizInputs = $item->getQuizInputs()->orderBy('sort_order asc')->all();
            $_quizInputs = array_map(function ($item2) {
                /**
                 * @var $item2 QuizInput
                 */
                $attrs2 = $item2->attributes;
                $quizInputOptions = $item2->getQuizInputOptions()->orderBy('sort_order asc')->all();
                $_quizInputOptions = array_map(function ($item3) {
                    /**
                     * @var $item3 QuizInputOption
                     */
                    $attrs3 = $item3->attributes;
                    $quizInputOptionToVotedResults = $item3->quizInputOptionToVotedResults;
                    $quiz_results_votes = [];
                    foreach ($quizInputOptionToVotedResults as $result_votes) {
                        $quiz_results_votes[$result_votes->quiz_voted_result_id] = $result_votes->votes;
                    }
                    $attrs3['quiz_results_votes'] = $quiz_results_votes;
                    return $attrs3;
                }, $quizInputOptions);
                $attrs2['quizInputOptions'] = $_quizInputOptions;

                $quizInputValidators = $item2->quizInputValidators;
                $attrs2['quiz_input_validator_ids'] = array_map(function ($item) {
                    return $item->id;
                }, $quizInputValidators);

                return $attrs2;
            }, $quizInputs);
            $attrs['quizInputs'] = $_quizInputs;
            return $attrs;
        }, $quizInputGroups);

        $_quizCharacters = array_map(function ($item) {
            /**
             * @var $item QuizCharacter
             */
            $attrs = $item->attributes;
            $quizSorters = $item->quizCharacterDataSorters;
            $_quizSorters = array_map(function ($item2) {
                /**
                 * @var $item2 QuizCharacterDataSorter
                 */
                $attrs2 = $item2->attributes;
                $quizFn = $item2->quizFn;
                $_quizFn = $quizFn->attributes;
                $attrs2['quizFn'] = $_quizFn;
                return $attrs2;
            }, $quizSorters);
            $quizFilters = $item->quizCharacterDataFilters;
            $_quizFilters = array_map(function ($item2) {
                /**
                 * @var $item2 QuizCharacterDataFilter
                 */
                $attrs2 = $item2->attributes;
                $quizFn = $item2->quizFn;
                $_quizFn = $quizFn->attributes;
                $attrs2['quizFn'] = $_quizFn;
                return $attrs2;
            }, $quizFilters);
            $quizCharacterMedia = $item->quizCharacterMedia;
            $_quizCharacterMedia = array_map(function ($item2) {
                /**
                 * @var $item2 QuizCharacterMedium
                 */
                $attrs2 = $item2->attributes;

                $quizCharacterMediumDataFilters = $item2->quizCharacterMediumDataFilters;
                $_quizCharacterMediumDataFilters = array_map(function ($item3) {
                    /**
                     * @var $item3 QuizCharacterMediumDataFilter
                     */
                    $attrs3 = $item3->attributes;
                    $quizFn = $item3->quizFn;
                    $_quizFn = $quizFn->attributes;
                    $attrs3['quizFn'] = $_quizFn;
                    return $attrs3;
                }, $quizCharacterMediumDataFilters);

                $quizCharacterMediumDataSorters = $item2->quizCharacterMediumDataSorters;
                $_quizCharacterMediumDataSorters = array_map(function ($item3) {
                    /**
                     * @var $item3 QuizCharacterMediumDataSorter
                     */
                    $attrs3 = $item3->attributes;
                    $quizFn = $item3->quizFn;
                    $_quizFn = $quizFn->attributes;
                    $attrs3['quizFn'] = $_quizFn;
                    return $attrs3;
                }, $quizCharacterMediumDataSorters);

                $quizStyles = $item2->quizStyles;
                $_quizStyleIds = array_map(function ($item3) {
                    /**
                     * @var $item3 QuizStyle;
                     */
                    return $item3->id;
                }, $quizStyles);
                $attrs2['quizCharacterMediumDataFilters'] = $_quizCharacterMediumDataFilters;
                $attrs2['quizCharacterMediumDataSorters'] = $_quizCharacterMediumDataSorters;
                $attrs2['quiz_style_ids'] = $_quizStyleIds;
                return $attrs2;
            }, $quizCharacterMedia);
            $attrs['quizCharacterDataSorters'] = $_quizSorters;
            $attrs['quizCharacterDataFilters'] = $_quizFilters;
            $attrs['quizCharacterMedia'] = $_quizCharacterMedia;
            return $attrs;
        }, $quizCharacters);

        $_quizParams = array_map(function ($item) {
            /**
             * @var $item QuizParam
             */
            $attrs = $item->attributes;
            $quizFn = $item->quizFn;
            $_quizFn = $quizFn->attributes;
            $attrs['quizFn'] = $_quizFn;
            return $attrs;
        }, $quizParams);

        $_quizObjectFilters = array_map(function ($item) {
            /**
             * @var $item QuizObjectFilter;
             */
            $attrs = $item->attributes;
            $quizFn = $item->quizFn;
            $_quizFn = $quizFn->attributes;
            $attrs['quizFn'] = $_quizFn;
            return $attrs;
        }, $quizObjectFilters);

        $_quizAlerts = array_map(function ($item) {
            /**
             * @var $item QuizAlert
             */
            $attrs = $item->attributes;
            return $attrs;
        }, $quizAlerts);

        $_quizResults = array_map(function ($item) {
            /**
             * @var $item QuizResult
             */
            $attrs = $item->attributes;
            $quizCharacterMedia = $item->quizCharacterMedia;
            $quizShapes = $item->quizShapes;
            $attrs['quiz_character_medium_ids'] = array_map(function ($item) {
                return $item->id;
            }, $quizCharacterMedia);
            $attrs['quiz_shape_ids'] = array_map(function ($item) {
                return $item->id;
            }, $quizShapes);
            return $attrs;
        }, $quizResults);

        $_quizShapes = array_map(function ($item) {
            /**
             * @var $item QuizShape
             */
            $attrs = $item->attributes;
            $quizStyles = $item->quizStyles;
            $attrs['quiz_style_ids'] = array_map(function ($item) {
                return $item->id;
            }, $quizStyles);
            $attrs['image_src'] = $item->image ? $item->image->getSource() : '';
            return $attrs;
        }, $quizShapes);
        $_quizStyles = array_map(function ($item) {
            /**
             * @var $item QuizStyle
             */
            $attrs = $item->attributes;
            return $attrs;
        }, $quizStyles);
        $_quizInputValidators = array_map(function ($item) {
            /**
             * @var $item QuizInputValidator
             */
            $attrs = $item->attributes;
            $quizFn = $item->quizFn;
            $_quizFn = $quizFn->attributes;
            $attrs['quizFn'] = $_quizFn;
            return $attrs;
        }, $quizInputValidators);

        return [
            'quiz' => $quiz,
            'quizCharacters' => $_quizCharacters,
            'quizInputGroups' => $_quizInputGroups,
            'quizParams' => $_quizParams,
            'quizObjectFilters' => $_quizObjectFilters,
            'quizResults' => $_quizResults,
            'quizAlerts' => $_quizAlerts,
            'quizShapes' => $_quizShapes,
            'quizInputValidators' => $_quizInputValidators,
            'quizStyles' => $_quizStyles,
        ];
    }
}
