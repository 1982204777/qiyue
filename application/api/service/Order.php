<?php
/**
 * Created by PhpStorm.
 * User: 随缘
 * Date: 2017/11/5
 * Time: 10:37
 */

namespace app\api\service;


use app\api\model\Product;
use app\lib\exception\OrderException;

class Order
{
    protected $uid;

    //订单的商品列表，也就是客户端传过来的products参数
    protected $oProducts;

    //真实的商品信息（包括库存量）
    protected $products;

    public function place($uid, $oProducts)
    {
        $this->uid = $uid;
        $this->oProducts = $oProducts;
        $this->products = $this->getProductsByOrder($oProducts);
    }

    private function getOrderStatus()
    {
        $status = [
            'is_pass' => true,
            'orderPrice' => 0,
            'pStatusArray' => []
        ];

        foreach ($this->oProducts as $oProduct) {
            $pStatus = $this->getProductStatus($oProduct['product_id'],
                $oProduct['count'], $this->products);
            if (!$pStatus['have_stock']) {
                $status['is_pass'] = false;
            }
            $status['orderPrice'] += $pStatus['total_price'];
            array_push($status['pStatusArray'], $pStatus);
        }

        return $status;
    }

    private function getProductStatus($oPID, $oCount, $products)
    {
        $pIndex = -1;
        $pStatus = [
            'id' => null,
            'have_stock' => false,
            'count' => 0,
            'name' => '',
            'total_price' => 0
        ];

        for ($i=0; $i<count($products); $i++) {
            if ($oPID == $products[$i]['id']) {
                $pIndex = $i;
            }
        }

        if (!$pIndex) {
            throw new OrderException([
                'msg' => 'id为'.$oPID.'的商品不存在，生成订单失败'
            ]);
        } else {
            $product = $products[$pIndex];
            $pStatus['id'] = $product['id'];
            $pStatus['count'] = $oCount;
            $pStatus['name'] = $product['name'];
            $pStatus['totalPrice'] = $product['price'] * $oCount;
            if (($product['stock'] - $oCount) >= 0) {
                $pStatus['have_stock'] = true;
            }
        }

        return $pStatus;
    }

    //根据订单信息查找真实的商品信息
    private function getProductsByOrder($oProducts)
    {
        $oPIds = [];
        foreach ($oProducts as $oProduct) {
            array_push($oPIds, $oProduct['product_id']);
        }

        $products = Product::all($oPIds)->visible([
            'id', 'price', 'stock', 'name', 'main_img_url'
        ])->toArray();

        return $products;
    }
}