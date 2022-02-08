<?php

namespace app\models\repositories;

use app\models\Repository;
use app\models\entities\Category;

class CategoryRepository extends Repository
{

    protected function getTableName()
    {
        return 'category';
    }

    protected function getEntityClass()
    {
       return Category::class;
    }
}