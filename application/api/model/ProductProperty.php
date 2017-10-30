<?php
/**
 * Created by PhpStorm.
 * User: 随缘
 * Date: 2017/10/30
 * Time: 20:17
 */

namespace app\api\model;


class ProductProperty extends BaseModel
{
    protected $hidden = [
        'delete_time',
        'id',
        'product_id'
    ];
}