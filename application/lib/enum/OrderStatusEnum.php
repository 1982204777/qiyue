<?php
/**
 * Created by PhpStorm.
 * User: 随缘
 * Date: 2017/11/6
 * Time: 20:14
 */

namespace app\lib\enum;


class OrderStatusEnum
{
    //待支付
    const UNPAID = 1;

    //已支付
    const PAID = 2;

    //已发货
    const DELIVERED = 3;

    //已支付，但库存不足
    const PAID_BUT_OUT_OF = 4;
}