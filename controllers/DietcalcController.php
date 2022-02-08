<?php

namespace app\controllers;

use app\engine\App;
use app\models\entities\Diet;

class DietcalcController extends Controller
{


    public function actionIndex(){

        echo $this->render("dietcalc", [
            'products' => App::call()->dietRepository->getDiet(),
            'sumnvpdiet' => App::call()->dietRepository->calcDiet(),
            'foods' => App::call()->foodsRepository->getFoodsAll(),
            'count' => 10,
            'button' => 'Добавить',
            'isAuth' => App::call()->userRepository->isAuth(),
            'userName' => App::call()->userRepository->getName()
        ]);
    }

    public function actionAdd(){

        $food_id = (int)App::call()->request->getParams()['food_id'];
        $count = (int)App::call()->request->getParams()['count'];
        $diet = new Diet($food_id, $count);
        $messages = App::call()->dietRepository->addFoodDiet($diet);
        $sumnvpdiet = App::call()->dietRepository->calcDiet();

        $response = [
            'message' => $messages,
            'sumnvpdiet' => $sumnvpdiet
        ];

        echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        die();

    }

    public function actionDelete()
    {
        $id = (int)App::call()->request->getParams()['id'];
        $messages = App::call()->dietRepository->deleteFoodToDiet($id);
        $sumnvpdiet = App::call()->dietRepository->calcDiet();

        $response = [
            'message' => $messages,
            'sumnvpdiet' => $sumnvpdiet
        ];

        echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        die();
    }

    public function actionEdit()
    {
        $id = (int)App::call()->request->getParams()['id'];

        echo $this->render("dietcalc", [
            'products' => App::call()->dietRepository->getDiet(),
            'sumnvpdiet' => App::call()->dietRepository->calcDiet(),
            'foods' => App::call()->foodsRepository->getFoodsAll($id),
            'foodsidedit' => App::call()->dietRepository->getOne($id)->foods_id,
            'idfoodtodiet' => $id,
            'count' => App::call()->dietRepository->getOne($id)->count,
            'button' => 'Сохранить',
            'action' => 'edit',
            'isAuth' => App::call()->userRepository->isAuth(),
            'userName' => App::call()->userRepository->getName()
        ]);

    }

    public function actionSave(){

        $foods_id = (int)App::call()->request->getParams()['food_id'];
        $count = (int)App::call()->request->getParams()['count'];
        $idfoodtodiet = (int)App::call()->request->getParams()['idfoodtodiet'];

        $dietitem = App::call()->dietRepository->getOne($idfoodtodiet);

        if($dietitem->foods_id == $foods_id)
        {
            $dietitem->count = $count;
            App::call()->dietRepository->save($dietitem);
            $messages = "ok";
        }

        $sumnvpdiet = App::call()->dietRepository->calcDiet();
        $response = [
            'message' => $messages,
            'sumnvpdiet' => $sumnvpdiet,
        ];

        echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        die();
    }

    public function actionCleanall(){

        App::call()->dietRepository->deleteAllDiet();
        $response = [
            'message' => 'ok'
        ];

        echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        die();

    }
}