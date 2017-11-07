<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2017/11/2
 * Time: 19:37
 */

namespace app\api\controller\v1;


use app\api\service\Token as TokenService;
use app\api\validate\IDMustBePositiveInt;
use app\api\validate\OrderPlace;
use app\api\validate\PagingParameter;
use app\lib\exception\OrderException;
use think\Controller;
use app\api\model\Order as OrderModel;
use app\api\service\Order as OrderService;

class Order extends BaseController
{
    // 用户在选择商品后，向API提交包含它所选择商品的相关信息
    // API在接收到消息后，需要检查订单相关商品的库存量
    // 有库存，把订单数据存入数据库中 = 下单成功了，返回客户端消息，告诉用户可以支付了
    // 调用支付接口，进行支付
    // 还需要再次进行库存量检测
    // 服务器这边就可以调用微信的支付接口进行支付
    // 小程序根据服务器返回的结果拉起微信支付
    // 微信会返回给我一个支付的结果（异步）
    // 成功：也需要进行库存量的检查
    // 成功：进行库存量的扣除
    // 失败：返回一个支付失败的结果（是由微信自动返回的）

    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'placeOrder'],
        'checkPrimaryScope' => ['only' => 'getDetail, getSummaryByUser']
    ];

    public function placeOrder()
    {
        (new OrderPlace())->goCheck();
        //因为传过来的是一个数组，所以要加一个 a
        $products = input('post.products/a');
        $uid = TokenService::getCurrentUID();

        $order = new OrderService();
        $status = $order->place($uid, $products);

        return $status;
    }

    public function getSummaryByUser($page = 1, $size = 15)
    {
        (new PagingParameter())->goCheck();

        $uid = TokenService::getCurrentUID();
        $pagingOrders = OrderModel::getSummaryByUser($uid, $page, $size);
        if ($pagingOrders->isEmpty()) {
            return [
                'data' => [],
                'current_page' => $pagingOrders->getCurrentPage()
            ];
        }
        return [
            'data' => $pagingOrders->hidden(['snap_items', 'snap_address', 'prepay_id'])
                ->toArray(),
//            'current_page' => $pagingOrders->getCurrentPage()
        ];
    }

    public function getDetail($id)
    {
        (new IDMustBePositiveInt())->goCheck();

        $order = OrderModel::get($id);
        if (!$order) {
            throw new OrderException;
        }

        return $order->hidden(['prepay_id']);
    }
}