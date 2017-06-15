<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "nav_item".
 *
 * @property integer $id
 * @property integer $creator_id
 * @property integer $updater_id
 * @property integer $parent_id
 * @property string $name
 * @property integer $target_model_id
 * @property integer $target_model_type
 * @property integer $active
 * @property integer $type
 * @property integer $sort_order
 * @property integer $create_time
 * @property integer $update_time
 *
 */
class NavItem extends MyActiveRecord
{
    const TARGET_MODEL_TYPE__ARTICLE_CATEGORY = 1;
    const TARGET_MODEL_TYPE__ARTICLE = 2;

    public static function getTargetModelTypes()
    {
        return [
            self::TARGET_MODEL_TYPE__ARTICLE_CATEGORY => Yii::t('app', 'Article Category'),
            self::TARGET_MODEL_TYPE__ARTICLE => Yii::t('app', 'Article'),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'nav_item';
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
            [[/*'creator_id', 'updater_id',*/ 'parent_id', 'target_model_id', 'target_model_type',
                'active', 'type', 'sort_order', /*'create_time', 'update_time'*/], 'integer'],
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
//            [['creator_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creator_id' => 'id']],
//            [['updater_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updater_id' => 'id']],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => NavItem::className(), 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'creator_id' => 'Creator ID',
            'updater_id' => 'Updater ID',
            'parent_id' => 'Parent ID',
            'name' => 'Name',
            'target_model_id' => 'Target Model ID',
            'target_model_type' => 'Target Model Type',
            'active' => 'Active',
            'type' => 'Type',
            'sort_order' => 'Sort Order',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }

}
