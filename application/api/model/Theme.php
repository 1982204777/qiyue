<?php
/**
 * Created by PhpStorm.
 * User: 随缘
 * Date: 2017/10/23
 * Time: 21:20
 */

namespace app\api\model;


class Theme extends BaseModel
{
    protected $hidden = ['topic_img_id', 'head_img_id', 'update_time', 'delete_time'];

    //一对一的关系较难理解，可以这么记： 当有外键时用belongsTo 另一张表是没有外键约束的

    public function topicImg()
    {
        return $this->belongsTo('Image', 'topic_img_id', 'id');
    }

    public function headImg()
    {
        return $this->belongsTo('Image', 'head_img_id', 'id');
    }

    public function products()
    {
        return $this->belongsToMany('Product', 'ThemeProduct', 'product_id', 'theme_id');
    }

    public static function getThemeOfProducts($id)
    {
        $theme = self::with('products,topicImg,headImg')->find($id);

        return $theme;
    }
}