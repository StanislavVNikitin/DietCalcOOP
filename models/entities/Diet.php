<?php

namespace app\models\entities;
use app\models\Model;

class Diet extends Model
{

    protected $id;
    protected $session_id;
    protected $user_id;
    protected $diet_user_id;
    protected $foods_id;
    protected $count;
    protected $created_at;
    protected $updated_at;


    protected $props = [
        'session_id' => false,
        'user_id' => false,
        'diet_user_id' => false,
        'foods_id' => false,
        'count' => false,
        'created_at' => false,
        'updated_at' => false
        ];

    protected $protectedProps = [
        'created_at',
        'updated_at'
    ];

    /**
     * @param $foods_id
     * @param $count
     */
    public function __construct($foods_id = null, $count = null)
    {
        $this->foods_id = $foods_id;
        $this->count = $count;
    }


}