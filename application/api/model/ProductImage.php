<?php
/**
 * Created by PhpStorm.
 * User: 随缘
 * Date: 2017/10/30
 * Time: 20:15
 */

namespace app\api\model;


class ProductImage extends BaseModel
{
    protected $hidden = [
        'delete_time',
        'product_id',
        'img_id'
    ];

    public function imgUrl()
    {
        return $this->belongsTo('Image', 'img_id', 'id');
    }
}