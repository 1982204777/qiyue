<?php
/**
 * Created by PhpStorm.
 * User: 随缘
 * Date: 2017/11/5
 * Time: 10:37
 */

namespace app\api\service;


use app\api\model\OrderProduct;
use app\api\model\Product;
use app\api\model\UserAddress;
use app\lib\exception\OrderException;
use app\lib\exception\UserException;
use app\api\model\Order as OrderModel;
use think\Exception;

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

        $status = $this->getOrderStatus();
        if (!$status['is_pass']) {
            $status['order_id'] = -1;
            return $status;
        }

        //开始创建订单
        $orderSnap = $this->snapOrder($status);
        $order = $this->createOrder($orderSnap);
        $order['pass'] = true;

        return $order;
    }

    private function createOrder($snap)
    {
        try {
            $orderNo = $this->makeOrderNo();
            $order = new OrderModel();
            $order->order_no = $orderNo;
            $order->user_id = $this->uid;
            $order->total_price = $snap['order_price'];
            $order->snap_img = $snap['snap_img'];
            $order->snap_name = $snap['snap_name'];
            $order->total_count = $snap['total_count'];
            $order->snap_items = json_encode($snap['pStatus']);
            $order->snap_address = $snap['snap_address'];

            $order->save();
            $order_id = $order->id;
            $create_time = $order->create_time;

            foreach ($this->oProducts as &$oProduct) {
                $oProduct['order_id'] = $order_id;
            }

            $orderProduct = new OrderProduct();
            $orderProduct->saveAll($this->oProducts);

            return [
                'order_no' => $orderNo,
                'order_id' => $order_id,
                'create_time' => $create_time
            ];
        } catch (Exception $e) {
            throw $e;
        }
    }

    public static function makeOrderNo()
    {
        $yCode = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
        $orderSn =
            $yCode[intval(date('Y') - 2017)] . strtoupper(dechex(date('m'))) .
            date('d') . substr(time(), -5) .substr(microtime(), 2 ,5) .
            sprintf('%02d', rand(0, 99));

        return $orderSn;
    }

    //生成订单快照
    private function snapOrder($status)
    {
        $snap = [
            'order_price' => 0,
            'total_count' => 0,
            'pStatus' => [],
            'snap_address' => null,
            'snap_name' => '',
            'snap_img' => ''
        ];

        $snap['order_price'] = $status['order_price'];
        $snap['total_count'] = $status['total_count'];
        $snap['pStatus'] = $status['pStatusArray'];
        $snap['snap_name'] = $this->products[0]['name'];
        $snap['snap_img'] = $this->products[0]['main_img_url'];
        $snap['snap_address'] = json_encode($this->getUserAddress());
        if (count($status['pStatusArray']) > 1) {
            $snap['snap_name'] .= '等';
        }

        return $snap;
    }

    private function getUserAddress()
    {
        $userAddress = UserAddress::where('user_id', '=', $this->uid)->find();
        if (!$userAddress) {
            throw new UserException([
                'msg' => '用户收货地址不存在，下单失败',
                'errorCode' => 60001
            ]);
        }

        return $userAddress->toArray();
    }

    private function getOrderStatus()
    {
        $status = [
            'is_pass' => true,
            'order_price' => 0,
            'total_count' => 0,
            'pStatusArray' => []
        ];

        foreach ($this->oProducts as $oProduct) {
            $pStatus = $this->getProductStatus($oProduct['product_id'],
                $oProduct['count'], $this->products);
            if (!$pStatus['have_stock']) {
                $status['is_pass'] = false;
            }
            $status['order_price'] += $pStatus['total_price'];
            $status['total_count'] += $pStatus['count'];
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

        if ($pIndex == -1) {
            throw new OrderException([
                'msg' => 'id为'.$oPID.'的商品不存在，生成订单失败'
            ]);
        } else {
            $product = $products[$pIndex];
            $pStatus['id'] = $product['id'];
            $pStatus['count'] = $oCount;
            $pStatus['name'] = $product['name'];
            $pStatus['total_price'] = $product['price'] * $oCount;
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