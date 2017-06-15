<?php
/**
 * Created by PhpStorm.
 * User: Quyet
 * Date: 6/15/2017
 * Time: 9:36 AM
 */

namespace backend\models;

/**
 * Class NavItem
 * @package backend\models
 *
 * @property User $creator
 * @property User $updater
 * @property NavItem $parent
 * @property NavItem[] $navItems
 */
class NavItem extends \common\models\NavItem
{
    /**
     * @return array
     */
    public static function dropDownListData()
    {
        /**
         * @param self[] $categories
         * @return array
         */
        $arrange = function ($categories) use (&$arrange) {
            $result = [];
            foreach ($categories as $category) {
                $children = $category->getNavItems()->all();
                if ($children) {
                    $result[$category->name] = [
                        $category->id => $category->name,
                        '__________' => $arrange($children),
                    ];
                } else {
                    $result[$category->name] = [$category->id => $category->name];
                }
            }
            return $result;
        };

        return array_merge([[-1 => '(Không có)']], $arrange(self::find()->where(['parent_id' => null])->all()));
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
    public function getUpdater()
    {
        return $this->hasOne(User::className(), ['id' => 'updater_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(NavItem::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNavItems()
    {
        return $this->hasMany(NavItem::className(), ['parent_id' => 'id']);
    }
}