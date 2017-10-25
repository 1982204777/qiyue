<?php
/**
 * Created by PhpStorm.
 * User: 随缘
 * Date: 2017/10/25
 * Time: 22:03
 */

namespace app\api\controller\v1;
use app\api\model\Product as ProductModel;
use app\api\validate\Count;
use app\lib\exception\ProductException;

class Product
{
    public function getRecentProducts($count = 15)
    {
        (new Count())->goCheck();

        $products = ProductModel::getRecentProducts($count);
        if ($products->isEmpty()) {
           throw new ProductException();
        }
        $products = $products->hidden(['summary']);

        return $products;
    }
}