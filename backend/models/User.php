<?php
namespace backend\models;

class User extends \mdm\admin\models\User
{
    public $reset_password;

    public function rules()
    {
        return array_merge(parent::rules(), [
            ['reset_password', 'string', 'min' => 6, 'max' => 32]
        ]);
    }

    public function getStatuses()
    {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_INACTIVE => 'Inactive',
        ];
    }
}