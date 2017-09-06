<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 4/4/2017
 * Time: 10:27 PM
 */

namespace frontend\models;


use yii\web\IdentityInterface;
use yii\base\NotSupportedException;

class User extends \common\models\User implements IdentityInterface
{
    /**
     * @param $fb_id
     * @return string
     */
    public static function getUsernameFromFbUId($fb_id)
    {
        return "fbu.$fb_id";
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne([
            'id' => $id,
            'status' => self::STATUS_ACTIVE,
            'type' => self::TYPE_FRONTEND,
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
            'type' => self::TYPE_FRONTEND,
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
            'type' => self::TYPE_FRONTEND,
        ]);
    }
}