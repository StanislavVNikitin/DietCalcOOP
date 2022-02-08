<?php

namespace app\controllers;

use app\engine\App;
use app\engine\Request;
use app\engine\Session;
use app\models\entities\User;
use app\models\repositories\RoleRepository;
use app\models\repositories\UserRepository;

class AdminuserController extends Controller
{
    public function actionIndex(){
        $roles = App::call()->roleRepository->getAll();
        $users = App::call()->userRepository->getUsers();
        if (App::call()->userRepository->getUserRole() == 1) {
            $isAdmin = true;
        } else{
            $isAdmin = false;
        }
        echo $this->render("admin/user", [
           'isAdmin' =>  $isAdmin,
            'users' => $users,
            'roles' => $roles,
            'action' => 'edit'
        ]);
    }


    public function actionDelete(){
        $id = App::call()->request->getParams()['id'];
        $user = App::call()->userRepository->getOne($id);
        if(!empty($user)){
            if (App::call()->userRepository->getUserRole() == 1 AND $_SESSION['auth']['id'] != $id) {
                $delete = App::call()->userRepository->delete($user);
                if($delete){
                    $messages = 'ok';
                }else{
                    $messages = 'Ошибка удаления';
                }
            } else {
                $messages = "Нет прав";
            }
        }else{
            $messages = "Пользователь не существует";
        }

        $response = [
            'message' => $messages
        ];

        echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        die();

    }

    public function actionSave(){
        $id = App::call()->request->getParams()['id'];
        $userupdate = App::call()->userRepository->getOne($id);
        if(!empty($userupdate)){
            if (App::call()->userRepository->getUserRole() == 1 AND $_SESSION['auth']['id'] != $id) {
                $userupdate->id = $id;
                $userupdate->login =  App::call()->request->getParams()['login'];
                $userupdate->email =  App::call()->request->getParams()['email'];
                $userupdate->role_id =  App::call()->request->getParams()['role'];
                $save = App::call()->userRepository->save($userupdate);
                if($save){
                    $messages = 'ok';
                }else{
                    $messages = 'Ошибка удаления';
                }
            } else {
                $messages = "Нет прав";
            }
        }else{
            $messages = "Пользователя не удалось создать";
        }

        $response = [
            'message' => $messages
        ];

        echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        die();

    }


}