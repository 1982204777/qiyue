<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2017/11/2
 * Time: 23:03
 */

namespace app\api\validate;


use app\lib\exception\ParameterException;

class OrderPlace extends BaseValidate
{
    protected $rule = [
        'products' => 'checkProducts'
    ];

    protected $singleRule = [
        'product_id' => 'require|isPositiveInteger',
        'count' => 'require|isPositiveInteger'
    ];

    protected function checkProducts($values)
    {
        if (!is_array($values)) {
            throw new ParameterException('商品参数不正确');
        }
        if (empty($values)) {
            throw new ParameterException('商品列表不能为空');
        }

        foreach ($values as $value) {
            $this->checkProduct($value);
        }
    }

    protected function checkProduct($value)
    {
        $validate = new BaseValidate($this->singleRule);
        $result = $validate->check($value);
        if (!$result) {
            throw new ParameterException('商品参数错误');
        }
    }
}