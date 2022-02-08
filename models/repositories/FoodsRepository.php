<?php

namespace app\models\repositories;

use app\engine\App;
use app\models\Repository;
use app\models\entities\Foods;


class FoodsRepository extends Repository
{
    public function getFoodsCategory($id)
    {
        $sql = "SELECT * FROM {$this->getTableName()} WHERE category_id = '{$id}'";
        return App::call()->db->queryAll($sql);
    }

    public function getFoodsAll()
    {
        return App::call()->foodsRepository->getAll();
    }

    protected function getTableName()
    {
        return 'foods';
    }

    protected function getEntityClass()
    {
        return Foods::class;
    }

}