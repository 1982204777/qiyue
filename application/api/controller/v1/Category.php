<?php
/**
 * Created by PhpStorm.
 * User: 随缘
 * Date: 2017/10/25
 * Time: 22:55
 */

namespace app\api\controller\v1;
use app\api\model\Category as CategoryModel;
use app\lib\exception\CategoryException;

class Category
{
    public function getAllCategories()
    {
        $categories = CategoryModel::all([], 'img');

        if ($categories->isEmpty()) {
            throw new CategoryException();
        }

        return $categories;
    }
}