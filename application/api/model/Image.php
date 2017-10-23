<?php

namespace app\api\model;

use think\Model;

class Image extends Model
{
    protected $visible = ['url'];

    public function getUrlAttr($value, $data)
    {
        $finalUrl = $value;
        if ($data['from'] == 1) {
            $finalUrl = config('setting.img_prefix').$finalUrl;
        }

        return $finalUrl;
    }
}
