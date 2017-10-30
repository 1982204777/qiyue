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

    public function images()
    {
        return $this->hasMany('ProductImage', 'product_id', 'id');
    }

    public function properties()
    {
        return $this->hasMany('ProductProperty', 'product_id', 'id');
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

    public static function getDetailOfProduct($id)
    {
        $product = self::with([
            'images' => function($query) {
                $query->with(['imgUrl'])->order('order', 'asc');
            }
        ])->with(['properties'])
            ->find($id);

        return $product;
    }
}