<?php

namespace app\models\repositories;

use app\engine\App;
use app\models\entities\User;
use app\models\Repository;


class UserRepository extends Repository
{
    public function auth($login, $pass) {
        $user = $this->getWhere('login', $login);


        if (password_verify($pass,$user->password_hash)) {
            if ( $user->role_id == App::call()->config['guest_user_role_id'] ) {
                die("Активируйте учетную запись, все информация отправлена Вам на емеил при регистрации!");
            }
            $_SESSION['auth']['login'] = $login;
            $_SESSION['auth']['id'] = $user->id;
            return true;
        } else {
            return false;
        }
    }

    public function isAuth() {
        if (isset($_COOKIE["hash"])) {
            $hash = $_COOKIE["hash"];
            $user = $this->getWhere('hash', $hash);
            $_SESSION['auth']['login'] = $user->login;
            $_SESSION['auth']['id'] = $user->id;
        }
        return isset($_SESSION['auth']['login']);
    }

    public function getName() {
        return $_SESSION['auth']['login'];
    }

    public function getUsers(){
        return $this->getAll();
    }

    public function getUserRole(){
        $userid = (int)$_SESSION['auth']['id'];
        $user = $this->getWhere('id', $userid);
        return $user->role_id;
    }

    public function getTableName() {
        return 'users';
    }

    protected function getEntityClass()
    {
        return User::class;
    }


}