<?php
/**
 * Created by PhpStorm.
 * User: 随缘
 * Date: 2017/10/30
 * Time: 21:39
 */

namespace app\lib\exception;


class UserException extends BaseException
{
    public $code = 404;
    public $msg = '用户不存在';
    public $errorCode = 60000;
}