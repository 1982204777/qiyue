<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2017/11/2
 * Time: 20:54
 */

namespace app\api\controller\v1;


use app\api\service\Token;
use think\Controller;

class BaseController extends Controller
{
    protected function checkPrimaryScope()
    {
        Token::needPrimaryScope();
    }

    protected function checkExclusiveScope()
    {
        Token::needExclusiveScope();
    }
}