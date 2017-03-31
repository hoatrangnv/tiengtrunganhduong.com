<?php

namespace common\behaviors;

use common\helpers\MyStringHelper;
use Yii;
use Closure;
use yii\base\Behavior;
use yii\base\Event;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;

class MySluggableBehavior extends \yii\behaviors\SluggableBehavior
{
    protected function getValue($event)
    {
        if ($this->attribute !== null) {
            if ($this->isNewSlugNeeded()) {
                $slugParts = [];
                foreach ((array) $this->attribute as $attribute) {
                    // Tieng Viet co dau --> khong dau
                    $slugParts[] = MyStringHelper::stripUnicode(ArrayHelper::getValue($this->owner, $attribute));
                }
                $slug = $this->generateSlug($slugParts);
            } else {
                return $this->owner->{$this->slugAttribute};
            }
        } else {
            $slug = parent::getValue($event);
        }

        return $this->ensureUnique ? $this->makeUnique($slug) : $slug;
    }
}