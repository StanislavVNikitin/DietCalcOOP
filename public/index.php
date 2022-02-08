<?php
session_start();

use app\engine\Autoload;
use app\engine\App;

//TODO сделать путь абсолютным
include dirname(__DIR__)."/engine/Autoload.php";
include dirname(__DIR__)."/vendor/autoload.php";

spl_autoload_register([new Autoload(), 'loadClass']);
$config = include "../config/config.php";

try {

    App::call()->run($config);

} catch(\Exception $exception) {
    var_dump($exception->getTrace());
}
