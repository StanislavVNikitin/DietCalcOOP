<?php

namespace app\models\entities;
use app\models\Model;



class Disease extends Model
{

    protected $id;
    protected $name;
    protected $description;

    protected $props = [
        'name' => false,
        'description' => false
    ];

    /**
     * @param $name
     * @param $description
     */
    public function __construct($name, $description)
    {
        $this->name = $name;
        $this->description = $description;
    }

}