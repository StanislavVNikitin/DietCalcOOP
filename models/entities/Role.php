<?php

namespace app\models\entities;

use app\models\Model;

class Role extends Model
{
    protected $id = null;
    protected $name;

    protected $props = [
        'name' => false
    ];

    public function __construct($name = null)
    {
        $this->name = $name;
    }
}