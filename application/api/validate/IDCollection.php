<?php
/**
 * Created by PhpStorm.
 * User: 随缘
 * Date: 2017/10/23
 * Time: 21:48
 */

namespace app\api\validate;


class IDCollection extends BaseValidate
{
    protected $rule = [
        'ids' => 'require|checkIDs'
    ];

    protected $message = [
        'ids' => 'ids必须是以逗号分隔的多个正整数'
    ];

    protected function checkIDs($ids)
    {
        $idsArr = explode(',', $ids);
        if (!$idsArr) {
            return false;
        }

        foreach($idsArr as $value) {
            if (!$this->isPositiveInteger($value)) {
                return false;
            }
        }

        return true;
    }
}