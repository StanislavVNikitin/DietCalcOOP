<?php

namespace app\models\repositories;

use app\models\entities\Role;

class RoleRepository extends \app\models\Repository
{

    protected function getTableName()
    {
        return 'role';
    }

    protected function getEntityClass()
    {
        return Role::class;
    }
}