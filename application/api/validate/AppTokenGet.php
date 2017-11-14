<?php
/**
 * Created by PhpStorm.
 * User: 随缘
 * Date: 2017/11/14
 * Time: 19:32
 */

namespace app\api\validate;


class AppTokenGet extends BaseValidate
{
    protected $rule = [
        'ac' => 'require|isNotEmpty',
        'se' => 'require|isNotEmpty'
    ];
}