<?php
/**
 * Created by PhpStorm.
 * User: 随缘
 * Date: 2017/10/23
 * Time: 21:24
 */

namespace app\api\controller\v1;


use app\api\validate\IDCollection;

class Theme
{
    /**
     * @ids string $ids
     * @url /theme?ids=id1,id2,id3....
     * @return  一组theme模型
     */
    public function getSimpleList($ids = '')
    {
        (new IDCollection())->goCheck($ids);

        return 'success';
    }
}