<?php
/**
 * Created by PhpStorm.
 * User: 随缘
 * Date: 2017/10/30
 * Time: 19:11
 */
return [
    'token_salt' => 'QKshB4o1dRmXTXkFnH',
    //微信支付回调的路由地址
    //Ngrok（反向代理）提供域名外网能够访问 不太安全
    'pay_back_url' => 'http://qiyue.com/api/v1/pay/notify'
];