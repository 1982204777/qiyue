<?php
/**
 * Created by PhpStorm.
 * User: 随缘
 * Date: 2017/10/21
 * Time: 16:49
 */

namespace app\lib\exception;


class ParameterException extends BaseException
{
    public $code = 400;
    public $msg = '参数错误';
    public $errorCode = 10000;
}