<?php
/**
 * Created by PhpStorm.
 * User: 随缘
 * Date: 2017/10/25
 * Time: 22:17
 */

namespace app\lib\exception;


class ProductException extends BaseException
{
    public $code = 404;
    public $message = '指定的产品不存在，请检查参数';
    public $errorCode = 20000;
}