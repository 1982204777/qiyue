<?php
/**
 * Created by PhpStorm.
 * User: 随缘
 * Date: 2017/10/28
 * Time: 9:38
 */

namespace app\api\validate;


class TokenGet extends BaseValidate
{
    protected $rule = [
        'code' => 'require|isNotEmpty'
    ];

    protected $message = [
        'code' => 'code必须有，不然不能获取token'
    ];
}