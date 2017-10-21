<?php
/**
 * Created by PhpStorm.
 * User: 随缘
 * Date: 2017/10/21
 * Time: 10:25
 */

namespace app\api\validate;


class IDMustBePositiveInt extends BaseValidate
{
    protected $rule = [
        'id' => 'require|isPositiveInteger',
        'num' => 'in:1,2,3'
    ];

    protected function isPositiveInteger($value, $rule = '', $data= '', $field = '')
    {
        if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0) {
            return true;
        } else {
            return $field.'必须是正整数';
        }
    }
}