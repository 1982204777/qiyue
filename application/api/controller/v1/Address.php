<?php
/**
 * Created by PhpStorm.
 * User: 随缘
 * Date: 2017/10/30
 * Time: 21:18
 */

namespace app\api\controller\v1;


use app\api\model\User as UserModel;
use app\api\model\UserAddress;
use app\api\service\Token as TokenService;
use app\api\validate\AddressNew;
use app\lib\enum\ScopeEnum;
use app\lib\exception\ForbiddenException;
use app\lib\exception\SuccessMessage;
use app\lib\exception\TokenException;
use app\lib\exception\UserException;
use think\Controller;

class Address extends BaseController
{
    protected $beforeActionList = [
        'checkPrimaryScope' => ['only' => 'createOrUpdateAddress,getUserAddress']
    ];

    public function createOrUpdateAddress()
    {
        $validate = new AddressNew();
        $validate->goCheck();
        //根据Token来获取uid
        //根据uid来查找用户数据，判断用户是否存在，如果不存在则抛出异常
        //获取用户从客户端提交来的地址信息
        //根据用户地址信息是否存在从而判断是添加地址还是更新地址
        $uid = TokenService::getCurrentUID();
        $user = UserModel::get($uid);

        if (!$user) {
            throw new UserException();
        }
        //只获取想要的参数 如果从客户端也传来一个uid ?
        $addressData = $validate->getDataByRule(input('post.'));
        $userAddress = $user->address;
        //使用关联模型的方式新增和更新数据
        if (!$userAddress) {
            $user->address()->save($addressData);
        } else {
            $user->address->save($addressData);
        }

        return json(new SuccessMessage(), 201);
    }

    public function getUserAddress()
    {
        $uid = TokenService::getCurrentUID();
        $userAddress = UserAddress::where('user_id', $uid)->find();

        if (!$userAddress) {
            throw new UserException([
                'msg' => '用户地址不存在',
                'errorCode' => 60001
            ]);
        }

        return $userAddress;
    }
}