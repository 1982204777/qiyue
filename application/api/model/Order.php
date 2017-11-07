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
}