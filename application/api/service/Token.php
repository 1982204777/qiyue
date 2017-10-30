<?php
/**
 * Created by PhpStorm.
 * User: 随缘
 * Date: 2017/10/30
 * Time: 19:06
 */

namespace app\api\service;


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
}