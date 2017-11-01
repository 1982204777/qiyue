<?php
/**
 * Created by PhpStorm.
 * User: 随缘
 * Date: 2017/10/21
 * Time: 11:20
 */

namespace app\api\validate;


use app\lib\exception\ParameterException;
use think\Exception;
use think\Request;
use think\Validate;

class BaseValidate extends Validate
{
    public function goCheck()
    {
        //获取http传入的参数
        //对这些参数做校验
        $request = Request::instance();
        $params = $request->param();
        $result = $this->batch()->check($params);
        if (!$result) {
            $e = new ParameterException([
                'msg' => $this->error
            ]);
            throw $e;
        } else {
            return true;
        }
    }

    protected function isPositiveInteger($value, $rule = '', $data= '', $field = '')
    {
        if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0) {
            return true;
        } else {
            return false;
        }
    }

    protected function isNotEmpty($value, $rule = '', $data = '', $field = '')
    {
        if (empty($value)) {
            return false;
        } else {
            return true;
        }
    }

    protected  function isMobile($value)
    {
        $rule = '^1(3|4|5|7|8)[0-9]\d{8}$^';
        $result = preg_match($rule, $value);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function getDataByRule($input)
    {
        if (array_key_exists('user_Id', $input) ||
        array_key_exists('uid', $input)) {
            throw new ParameterException([
                'msg' => '参数中含有非法的参数名user_id或uid'
            ]);
        }

        $newArr = [];

        foreach ($this->rule as $key => $val) {
            $newArr[$key] = $input[$key];
        }

        return $newArr;
    }


}