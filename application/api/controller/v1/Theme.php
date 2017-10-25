<?php
/**
 * Created by PhpStorm.
 * User: 随缘
 * Date: 2017/10/23
 * Time: 21:24
 */

namespace app\api\controller\v1;


use app\api\validate\IDCollection;
use app\api\model\Theme as ThemeModel;
use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\ThemeException;

class Theme
{
    /**
     * @ids string $ids
     * @url /theme?ids=id1,id2,id3....
     * @return  一组theme模型
     */
    public function getSimpleList($ids = '')
    {
        (new IDCollection())->goCheck();
        $ids = explode(',', $ids);
        $result = ThemeModel::with('topicImg,headImg')->select($ids);

        if ($result->isEmpty()) {
            throw new ThemeException();
        }

        return $result;
    }

    /**
     * @param $id
     * @url /theme/:id
     * @return
     */
    public function getThemeOfProducts($id)
    {
        (new IDMustBePositiveInt())->goCheck();

        $theme = ThemeModel::getThemeOfProducts($id);
        if (!$theme) {
            throw new ThemeException();
        }

        return $theme;
    }
}