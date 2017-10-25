<?php
/**
 * Created by PhpStorm.
 * User: 随缘
 * Date: 2017/10/23
 * Time: 21:19
 */

namespace app\api\model;


class Product extends BaseModel
{
    protected $hidden = ['update_time', 'delete_time', 'category_id',
        'from', 'create_time', 'update_time', 'pivot'];

    public function getMainImgUrlAttr($value, $data)
    {
        return $this->prefixImgUrl($value, $data);
    }

    public static function getRecentProducts($count)
    {
        $products = self::limit($count)->order('create_time desc')->select();

        return $products;
    }

    public static function getCategoryOfProducts($category_id)
    {
        $products = self::where('category_id', '=', $category_id)->select();

        return $products;
    }
}