<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2017/11/2
 * Time: 19:11
 */

namespace app\lib\exception;


class ForbiddenException extends BaseException
{
    public $code = 403;
    public $msg = '权限不够';
    public $errorCode = 10001;
}