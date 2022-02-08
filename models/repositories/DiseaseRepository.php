<?php

namespace app\models\repositories;
use app\models\Repository;
use app\models\entities\Disease;


class DiseaseRepository extends Repository
{

    protected function getTableName()
    {
        return 'orphan_disease';
    }

    protected function getEntityClass()
    {
        return Disease::class;
    }
}