<?php

namespace app\controllers;

use app\engine\App;

class ProfileController extends Controller
{
    public function actionIndex(){
        echo $this->render("profile", [
            'profile' => App::call()->profileRepository->getWhere('user_id', $_SESSION['auth']['id']),
            'userName' => App::call()->userRepository->getName(),
            'diseases' => App::call()->diseaseRepository->getAll()
        ]);
    }

    public function actionSave()
    {
        $userid = App::call()->request->getParams()['id'];
        if (password_verify(App::call()->request->getParams()['passwordconf'], App::call()->userRepository->getOne($userid)->password_hash)) {
            $profile = App::call()->profileRepository->getWhere("user_id", $userid);
            if (isset($profile)) {
                $profile->id = App::call()->request->getParams()['id'];
                $profile->firstname = App::call()->request->getParams()['firstname'];
                $profile->lastname = App::call()->request->getParams()['lastname'];
                $profile->disease_id = App::call()->request->getParams()['disease_id'];
                $profile->gender = App::call()->request->getParams()['gender'];
                $profile->weight = App::call()->request->getParams()['weight'];
                $profile->height = App::call()->request->getParams()['height'];
                $profile->birthday = App::call()->request->getParams()['birthday'];
                $profilesave = App::call()->profileRepository->update($profile);
                if($profilesave){
                    $messages = 'ok';
                }else{
                    $messages = ' Ошибка сохранения данных в профайле.';
                }
            }else{
                $messages = ' У пользователя нет профайла.';
            }
        }else{
            $messages = ' Пароль не верен!';
        }
        $response = [
            'message' => $messages
        ];

        echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        die();

    }


}