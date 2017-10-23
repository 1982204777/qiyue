<?php
/**
 * Created by PhpStorm.
 * User: 随缘
 * Date: 2017/10/21
 * Time: 12:33
 */

namespace app\api\model;


use think\Db;
use think\Exception;
use think\Model;

class Banner extends Model
{
    protected $hidden = ['delete_time', 'update_time'];

    public function items()
    {
        return $this->hasMany('BannerItem', 'banner_id', 'id');
    }

    //根据banner的id获取banner表的信息
    public static function getBannerById($id)
    {
        $banner = self::with(['items', 'items.image'])->find($id);

        return $banner;
    }
}