<?php
/**
 * Created by PhpStorm.
 * User: 随缘
 * Date: 2017/10/28
 * Time: 9:45
 */

namespace app\api\service;


use app\lib\exception\TokenException;
use app\lib\exception\WechatException;
use think\Exception;
use app\api\model\User as UserModel;

class UserToken extends Token
{
    protected $code;
    protected $wxAppId;
    protected $wxAppSecret;
    protected $wxLoginUrl;

    function __construct($code)
    {
        $this->code = $code;
        $this->wxAppId = config('wechat.app_id');
        $this->wxAppSecret = config('wechat.app_secret');
        $this->wxLoginUrl = sprintf(config('wechat.login_url'),
            $this->wxAppId, $this->wxAppSecret, $this->code);
    }

    public function get()
    {
       $result = curl_get($this->wxLoginUrl);
       $wxResult = json_decode($result, true);
        if (empty($wxResult)) {
            //当$code为空时，返回的wxResult就是空
            throw new Exception('获取session_key及openid时异常，微信内部错误');
        } else {
            $loginFail = array_key_exists('errcode', $wxResult);
            if ($loginFail) {
                $this->processLoginError($wxResult);
            } else {
               return $this->grantToken($wxResult);
            }
        }
    }

    private function processLoginError($wxResult)
    {
        throw new WechatException([
            'msg' => $wxResult['errmsg'],
            'errorCode' => $wxResult['errcode']
        ]);
    }

    private function grantToken($wxResult)
    {
        //拿到openid
        //数据库看是否已经存在openid
        //如果存在则不处理，如果不存在则新增一条user记录
        //生成令牌，准备缓存数据，写入缓存
        //把令牌返回到客户端去
        //key:令牌
        //value: wxResult uid scope
        $openid = $wxResult['openid'];

        $user = UserModel::getUserByOpenid($openid);
        if ($user) {
            $uid = $user->id;
        } else {
            $uid = $this->newUser($openid);
        }
        $cacheValue = $this->createCacheValue($wxResult, $uid);
        $token = $this->saveToCache($cacheValue);

        return $token;
    }

    private function newUser($openid)
    {
        $user = UserModel::create([
            'openid' => $openid
        ]);

        return $user->id;
    }

    private function createCacheValue($wxResult, $uid)
    {
        $cacheValue = $wxResult;
        $cacheValue['uid'] = $uid;
        $cacheValue['scope'] = 16;

        return $cacheValue;
    }

    private function saveToCache($cacheValue)
    {
        $key = parent::generateToken();
        //正常写入缓存需得是字符串
        $value = json_encode($cacheValue);
        $token_expire_in = config('setting.token_expire_in');
        $request = cache($key, $value, $token_expire_in);

        if (!$request) {
            throw new TokenException([
                'msg' => '服务器缓存异常',
                'errorCode' => 10005
            ]);
        }

        return $key;
    }
}