<?php
/**
 * Created by PhpStorm.
 * User: 随缘
 * Date: 2017/10/28
 * Time: 9:37
 */

namespace app\api\model;


class User extends BaseModel
{
    public static function getUserByOpenid($openid)
    {
        $user = self::where('openid', '=', $openid)->find();

        return $user;
    }
}