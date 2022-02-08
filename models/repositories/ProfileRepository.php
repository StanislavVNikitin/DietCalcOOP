<?php

namespace app\models\repositories;

use app\models\entities\Profile;

class ProfileRepository extends \app\models\Repository
{

    protected function getTableName()
    {
        return 'profiles';
    }

    protected function getEntityClass()
    {
        return Profile::class;
    }
}