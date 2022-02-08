<?php


namespace app\controllers;


use app\engine\App;
use app\engine\Render;
use app\interfaces\IRenderer;
use app\models\entities\User;
use app\models\repositories\UserRepository;

class Controller
{
    //TODO вынести общий функционал в родителя Controller в абстрактный класс
    private $action;
    private $defaultAction = 'index';
    private $defaultLayout = 'layout';
    private $useLayout = true;

    private $renderer;


    public function __construct(IRenderer $render)
    {
        $this->renderer = $render;
    }


    public function runAction($action = null)
    {
        $this->action = $action ?? $this->defaultAction;
        $method = 'action' . ucfirst($this->action);

        if (method_exists($this, $method)) {
            $this->$method();
        }
    }

    public function render($template, $params = [])
    {
        if ($this->useLayout) {
            if (App::call()->userRepository->getUserRole() == 1) {
                $isAdmin = true;
            } else{
                $isAdmin = false;
            }

            return $this->renderTemplate("layouts/{$this->defaultLayout}", [
                'menu' => $this->renderTemplate('menu', [
                    'isAuth' => App::call()->userRepository->isAuth(),
                    'isAdmin' => $isAdmin,
                    'userName' => App::call()->userRepository->getName(),
                    'sumnvpdiet' => App::call()->dietRepository->calcDiet()
                ]),
                'content' => $this->renderTemplate($template, $params)
            ]);
        } else {
            return $this->renderTemplate($template, $params);
        }

    }

    //['catalog' => $catalog]
    public function renderTemplate($template, $params = [])
    {
        return $this->renderer->renderTemplate($template, $params);
    }

}