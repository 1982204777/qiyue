<?php
/**
 * Created by PhpStorm.
 * User: 随缘
 * Date: 2017/10/16
 * Time: 18:33
 */

namespace app\api\controller\v1;

use app\api\validate\IDMustBePositiveInt;
use app\api\model\Banner as BannerModel;
use app\lib\exception\BannerMissException;
use think\Exception;

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
        (new IDMustBePositiveInt())->goCheck();

        $banner = BannerModel::getBannerById($id);

        if (!$banner) {
            throw new BannerMissException();
        }

        return $banner;
    }
}