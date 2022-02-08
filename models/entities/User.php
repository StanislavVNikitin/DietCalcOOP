<?php

namespace app\models\entities;


use app\models\Model;
use app\models\repositories\UserRepository;

class User extends Model
{
    protected $id = null;
    protected $login;
    protected $password_hash;
    protected $hash;
    protected $email;
    protected $email_confirm_hash;
    protected $role_id;

    protected $props = [
        'login' => false,
        'password_hash' => false,
        'hash' => false,
        'email' => false,
        'email_confirm_hash' => false,
        'role_id' => false
    ];

    public function __construct($login = null, $password_hash = null, $email = null, $email_confirm_hash = null, $role_id = null)
    {
        $this->login = $login;
        $this->password_hash = $password_hash;
        $this->role_id = $role_id;
        $this->email = $email;
        $this->email_confirm_hash = $email_confirm_hash;
    }

}