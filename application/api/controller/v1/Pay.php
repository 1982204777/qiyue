<?php
/**
 * Created by PhpStorm.
 * User: 随缘
 * Date: 2017/11/6
 * Time: 19:08
 */

namespace app\api\controller\v1;


use app\api\validate\IDMustBePositiveInt;
use app\api\service\Pay as PayService;
use app\api\service\WxNotify as WxNotifyService;

class Pay extends BaseController
{
    protected $beforeActionList = [
        'only' => 'getPreOrder'
    ];

    public function getPreOrder($id = '')
    {
        (new IDMustBePositiveInt())->goCheck();

        $payService = new PayService($id);

        return $payService->pay();
    }

    public function receiveNotify()
    {
        //通知频率为15/15/30/180/1800/1800/1800/1800/3600，单位：秒

        //1.检查库存量，超卖
        //2.更新这个订单的status状态
        //3.减库存
        //如果成功处理，我们返回微信成功处理的信息。否则，我们需要返回没有成功处理

        //特点：post：xml格式；不会携带参数

        $notify = new WxNotifyService();
        $notify->Handle();
    }

    public function redirectNotify()
    {
        $notify = new WxNotifyService();
        $notify->Handle();

        $xdebug = '';
        $xmlData = file_get_contents('php://input');
        $result = curl_post_raw('http://qiyue.com/api/v1/pay/re_notify?'.$xdebug, $xmlData);
    }
}