<?php
/**
 * Created by PhpStorm.
 * User: 随缘
 * Date: 2017/10/16
 * Time: 18:33
 */

namespace app\api\controller\v2;

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
        $banner = 'This is v2 banner';

        return $banner;
    }
}