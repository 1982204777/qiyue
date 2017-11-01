<?php
/**
 * Created by PhpStorm.
 * User: 随缘
 * Date: 2017/10/30
 * Time: 21:57
 */

namespace app\lib\exception;


class SuccessMessage extends BaseException
{
    public $code = 201;
    public $msg = 'success';
    public $errorCode = 0;
}