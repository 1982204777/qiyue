<?php
/**
 * Created by PhpStorm.
 * User: 随缘
 * Date: 2017/10/28
 * Time: 9:36
 */

namespace app\api\controller\v1;


use app\api\service\UserToken;
use app\api\validate\TokenGet;
use app\lib\exception\ParameterException;
use think\Exception;
use app\api\service\Token as TokenService;

class Token
{
    public function getToken($code = '')
    {
        (new TokenGet())->goCheck();

        $ut = new UserToken($code);
        $token = $ut->get();

        return [
            'token' => $token
        ];
    }

    public function verifyToken($token = '')
    {
        if (!$token) {
            throw new ParameterException([
                'token不允许为空'
            ]);
        }

        $valid = TokenService::verifyToken($token);

        return [
            'isValid' => $valid
        ];
    }
}