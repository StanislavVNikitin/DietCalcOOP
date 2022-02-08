<?php

namespace app\models\entities;

class Profile extends \app\models\Model
{
    protected $keyFieldName = 'user_id';

    protected $user_id;
    protected $gender;
    protected $disease_id;
    protected $weight;
    protected $firstname;
    protected $lastname;
    protected $height;
    protected $birthday;
    protected $created_at;

    protected $props = [
        'user_id' => false,
        'gender'  => false,
        'disease_id' => false,
        'weight' => false,
        'firstname' => false,
        'lastname' => false,
        'height' => false,
        'birthday' => false,
        'created_at' => false
    ];

    protected $protectedProps = [
        'created_at'
    ];

    /**
     * @param $user_id
     * @param $gender
     * @param $disease_id
     * @param $weight
     * @param $firstname
     * @param $lastname
     * @param $height
     * @param $birthday
     */

    public function __construct($user_id = null, $gender = null, $disease_id = 100, $weight = null, $firstname = null, $lastname= null, $height = null, $birthday = null)
    {
        $this->user_id = $user_id;
        $this->gender = $gender;
        $this->disease_id = $disease_id;
        $this->weight = $weight;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->height = $height;
        $this->birthday = $birthday;
    }


}