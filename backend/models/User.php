<?php
namespace backend\models;

use yii\web\IdentityInterface;
use yii\base\NotSupportedException;

class User extends \common\models\User implements IdentityInterface
{

    public $reset_password;

    public function rules()
    {
        return array_merge(
            parent::rules(),
            [
                ['pen_name', 'string', 'min' => 3, 'max' => 255],
                ['reset_password', 'string', 'min' => 6, 'max' => 32],
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne([
            'id' => $id,
            'status' => self::STATUS_ACTIVE,
            'type' => self::TYPE_BACKEND,
        ]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne([
            'username' => $username,
            'status' => self::STATUS_ACTIVE,
            'type' => self::TYPE_BACKEND,
        ]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
            'type' => self::TYPE_BACKEND,
        ]);
    }

}