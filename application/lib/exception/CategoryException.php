<?php
/**
 * Created by PhpStorm.
 * User: 随缘
 * Date: 2017/10/25
 * Time: 23:01
 */

namespace app\lib\exception;


class CategoryException extends BaseException
{
    public $code = 404;
    public $message = '指定的分类不存在，请检查参数';
    public $errorCode = 50000;
}