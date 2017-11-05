<?php
/**
 * Created by PhpStorm.
 * User: 随缘
 * Date: 2017/11/5
 * Time: 11:17
 */

namespace app\lib\exception;


class OrderException extends BaseException
{
    public $code = 404;

    public $msg = '订单不存在，请检查参数';

    public $errorCode = 80000;
}