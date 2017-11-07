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

    }
}