<?php
/**
 * Created by PhpStorm.
 * User: 随缘
 * Date: 2017/10/30
 * Time: 19:06
 */

namespace app\api\service;


use app\lib\exception\TokenException;
use think\Cache;
use think\Exception;
use think\Request;

class Token
{
    public static function generateToken()
    {
        //32个字符组成一组随机字符串
        $randChars = getRandChars();
        //用三组字符串，进行md5加密
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
        //salt 盐 写在配置文件中
        $salt = config('secure.token_salt');

        return md5($randChars.$timestamp.$salt);
    }

    public static function getCurrentTokenVar($key)
    {
        $token = Request::instance()->header('token');
        $vars = Cache::get($token);
        if (!$vars) {
            throw new TokenException();
        } else {
            if (!is_array($vars)) {
                $vars = json_decode($vars, true);
            }
            if (array_key_exists($key, $vars)) {
               return $vars[$key];
            } else {
                throw new Exception('尝试获取的Token变量并不存在');
            }
        }
    }

    public static function getCurrentUID()
    {
        $uid = self::getCurrentTokenVar('uid');

        return $uid;
    }
}