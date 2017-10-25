<?php
/**
 * Created by PhpStorm.
 * User: 随缘
 * Date: 2017/10/25
 * Time: 23:33
 */

namespace app\api\validate;


class CategoryId extends BaseValidate
{
    protected $rule = [
        'category_id' => 'require|isPositiveInteger'
    ];
}