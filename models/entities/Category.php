<?php

namespace app\models\entities;

use app\models\Model;

class Category extends Model
{
    protected $id;
    protected $name;
    protected $image;

    protected $props = [
        'name' => false,
        'image' => false
    ];

    /**
     * @param $name
     * @param $image
     */
    public function __construct($name = null, $image = null)
    {
        $this->name = $name;
        $this->image = $image;
    }


}