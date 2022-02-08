<?php

namespace app\controllers;

use app\engine\App;

class CategoryController extends Controller
{
    public function actionIndex(){

        echo $this->render("category",[
            'categories' => App::call()->categoryRepository->getAll()
        ]);
    }

    public function actionView(){
        $id = App::call()->request->getParams()['id'];
        $category = App::call()->categoryRepository->getOne($id);
        if (isset($category)) {
            echo $this->render("viewcategory",[
                'categoryfood' => App::call()->foodsRepository->getFoodsCategory($id),
                'NameCategory' => $category->name
            ]);
        }
    }

}