<?php
/**
 * Created by PhpStorm.
 * User: 随缘
 * Date: 2017/10/25
 * Time: 22:56
 */

namespace app\api\model;


class Category extends BaseModel
{
    public $hidden = ['update_time', 'delete_time'];

    public function img()
    {
        return $this->belongsTo('Image', 'topic_img_id', 'id');
    }
}