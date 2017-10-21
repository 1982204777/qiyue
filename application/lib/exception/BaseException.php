<?php
/**
 * Created by PhpStorm.
 * User: 随缘
 * Date: 2017/10/21
 * Time: 15:18
 */

namespace app\lib\exception;


use think\Exception;

class BaseException extends Exception
{
    //HTTP状态码 404 200
    public $code = 404;

    //错误具体信息
    public $msg = '参数错误';

    //自定义的错误码
    public $errorCode = 10000;
}