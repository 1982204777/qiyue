<?php
/**
 * Created by PhpStorm.
 * User: 随缘
 * Date: 2017/11/5
 * Time: 12:58
 */

namespace app\api\model;


class Order extends BaseModel
{
    protected $hidden = ['user_id', 'delete_time', 'update_time'];

    protected $autoWriteTimestamp = true;

    public function getSnapItemsAttr($value)
    {
        if (empty($value)) {
            return null;
        }
        
        return json_decode($value);
    }

    public function getSnapAddressAttr($value)
    {
        if (empty($value)) {
            return null;
        }

        return json_decode($value);
    }

    public static function getSummaryByUser($uid, $page = 1, $size = 15)
    {
        $pagingData = self::where('user_id', '=', $uid)->order('create_time desc')
            ->paginate($size, false, ['page' => $page]);

        return $pagingData;
    }

    public static function getSummaryByPage($page, $size)
    {
        $pagingData = self::order('create_time desc')
            ->paginate($size, true, ['page' => $page]);

        return $pagingData;
    }
}