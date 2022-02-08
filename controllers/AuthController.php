<?php


namespace app\controllers;


use app\engine\App;
use app\engine\Request;
use app\models\entities\Profile;
use app\models\entities\User;
use app\models\repositories\UserRepository;

class AuthController extends Controller
{

    public function actionIndex(){

            echo $this->render("auth/login", [
                'isAuth' => App::call()->userRepository->isAuth(),
                'userName' => App::call()->userRepository->getName()
            ]);

    }

    public function actionLogin() {
        $login = App::call()->request->getParams()['login'];
        $pass = App::call()->request->getParams()['pass'];
        $save = App::call()->request->getParams()['save'];
        if (App::call()->userRepository->auth($login, $pass)) {
            if($save){
                $userid = (int)$_SESSION['auth']['id'];
                $user = App::call()->userRepository->getOne($userid);
                $user->hash = uniqid(rand(), true);
                App::call()->userRepository->save($user);
                setcookie("hash", $user->hash, time() + App::call()->config['life_time_cookie'], "/");
            }
            header("Location:" . $_SERVER['HTTP_REFERER']);
            die();
        } else {
            die("Не верный логин пароль");
        }
    }

    public function actionLogout() {
        session_destroy();
        setcookie("hash", "", time() - 1, "/");
        setcookie("dietcalc", "", time() - 1, "/");
        $_SESSION['auth'] = "";
        header("Location:" . $_SERVER['HTTP_REFERER']);
        die();
    }

    public function actionRegister(){
        $login = App::call()->request->getParams()['username'];
        $email = App::call()->request->getParams()['email'];
        $password = App::call()->request->getParams()['password'];
        $passwordconfirm = App::call()->request->getParams()['password_confirm'];
        $email_confirm_hash = uniqid(rand(), true);
        if ($login && $email && ($password === $passwordconfirm)) {
            $user = new User($login, password_hash($password, PASSWORD_DEFAULT), $email, $email_confirm_hash, 5);
            App::call()->userRepository->save($user);
            $subject = 'Подтверждение регстрации на сайте Диетологический калькулятор';
            $message = 'Вы зарегистрировались на сайте Диетологического калькулятора, для активации аккаунта вам нужно пройти по ссылке подтвеждения: 
            http://dcv2/auth/emailconfirm/?confirm_email='.$email.'&confirm_key='.$email_confirm_hash;
            $headers = array(
                'From' => 'oanews@yandex.ru',
                'Reply-To' => 'oanews@yandex.ru',
                'X-Mailer' => 'PHP/' . phpversion()
            );
            mail($email, $subject, $message, $headers);
        }
        header("Location: " . "/auth");
        die();
    }
    public function actionRegisterform(){

        echo $this->render("auth/register");

    }

    public function actionEmailconfirm(){

        $confirm_key = App::call()->request->getParams()['confirm_key'];
        $confirm_email = App::call()->request->getParams()['confirm_email'];
        if (isset($confirm_key) && isset($confirm_email)) {
            $user = App::call()->userRepository->getWhere('email_confirm_hash', $confirm_key);
            if(!empty($user)){
                if($user->email == $confirm_email) {
                    if((int)$user->role_id == 5 ){
                        $user->role_id = 4;
                        $user->email_confirm_hash = null;
                        $profile = (new Profile($user->id));
                        App::call()->userRepository->save($user);
                        App::call()->profileRepository->save($profile);
                        header("Location: " . "/auth");
                        die();
                    }else {
                        die("Роль уже выше Не подтвержденной!");
                    }
                }else{
                    die("Некорректные данные подтверждения. Email!");
                }
            }else {
                die("Некорректные данные подтверждения!");
            }
        }else{
            die("Некорректные  параметры подтверждения!");
        }

    }

}