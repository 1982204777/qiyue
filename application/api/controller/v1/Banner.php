<?php
/**
 * Created by PhpStorm.
 * User: 随缘
 * Date: 2017/10/16
 * Time: 18:33
 */

namespace app\api\controller\v1;


use app\api\validate\IDMustBePositiveInt;

class Banner
{
    /**
     * 获取指定id的banner信息
     * @url /banner/:id
     * @http GET
     * @$id banner的id号
     */
    public function getBanner($id)
    {
//        $data = [
//            'id' => $id
//        ];
//
//        $validate = new IDMustBePositiveInt();
//
//        $result = $validate->batch()->check($data);
//        if ($result) {
//            echo 1;
//        } else {
//            echo 2;
//        }
        (new IDMustBePositiveInt())->goCheck();
    }
}