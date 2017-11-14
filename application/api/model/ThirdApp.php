<?php
/**
 * Created by PhpStorm.
 * User: 随缘
 * Date: 2017/11/14
 * Time: 19:36
 */

namespace app\api\model;


class ThirdApp extends BaseModel
{
    public static function check($ac, $se)
    {
        $app = self::where('app_id', '=', $ac)
                ->where('app_secret', '=', $se)
                ->find();

        return $app;
    }
}