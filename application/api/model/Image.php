<?php

namespace app\api\model;

use think\Model;

class Image extends BaseModel
{
    protected $visible = ['url'];

    public function getUrlAttr($value, $data)
    {
        return $this->prefixImgUrl($value, $data);
    }
}
