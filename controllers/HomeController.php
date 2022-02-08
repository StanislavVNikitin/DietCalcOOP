<?php

namespace app\controllers;
use app\engine\App;

class HomeController extends Controller
{
    public function actionIndex(){

        echo $this->render("index");
    }

}