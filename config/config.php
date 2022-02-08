<?php

use app\engine\Db;
use app\engine\Request;
use app\engine\Session;
use \app\engine\TwigRender;
use \app\engine\Render;
use app\models\repositories\UserRepository;
use app\models\repositories\RoleRepository;
use app\models\repositories\ProfileRepository;
use app\models\repositories\DiseaseRepository;
use app\models\repositories\CategoryRepository;
use app\models\repositories\FoodsRepository;
use app\models\repositories\DietRepository;
use Buki\Pdox;

return [
    'root_dir' => dirname(__DIR__),
    'ds' => DIRECTORY_SEPARATOR,
    'controllers_namespaces' => 'app\\controllers\\',
    'views_dir' => '../views/',
    'product_per_page' => 2,
    'life_time_cookie'=> 3600*24*7,
    'guest_user_role_id' => 5,
    'components' => [
        'db' => [
            'class' => Db::class,
            'driver' => 'mysql',
            'host' => '192.168.11.3',
            'port' => '3306',
            'login' => 'stas',
            'password' => '0,ybycr',
            'database' => 'dietcalc2',
            'charset' => 'utf8'
        ],
        'db2' => [
            'class' => Db::class,
            'driver' => 'mysql',
            'host' => '192.168.11.3',
            'port' => '3306',
            'login' => 'stas',
            'password' => '0,ybycr',
            'database' => 'dietcalc',
            'charset' => 'utf8'
        ],
        'db3' => [
            'class' => Db::class,
            'driver' => 'pgsql',
            'host' => 'localhost',
            'port' => '5432',
            'login' => 'postgres',
            'password' => 'postgres',
            'database' => 'dietcalc',
            'charset' => 'utf8'
        ],
        'ormDb' => [
            'class'     => Pdox::class,
            'config' => ['driver'    => 'mysql',
                         'host'      => '192.168.11.3',
                         'port'      => '3306',
                         'database'  => 'dietcalc2',
                         'username'  => 'stas',
                         'password'  => '0,ybycr',
                         'charset'   => 'utf8']
        ],
        'request' => [
            'class' => Request::class
        ],
        'session' => [
            'class' => Session::class
        ],
        'userRepository' => [
            'class' => UserRepository::class
        ],
        'roleRepository' => [
            'class' => RoleRepository::class
        ],
        'profileRepository' => [
            'class' => ProfileRepository::class
        ],
        'diseaseRepository' => [
            'class' => DiseaseRepository::class
        ],
        'categoryRepository' => [
            'class' => CategoryRepository::class
        ],
        'foodsRepository' => [
            'class' => FoodsRepository::class
        ],
        'dietRepository' => [
            'class' => DietRepository::class
        ],
        'twigRender' => [
            'class' => TwigRender::class
        ],
        'render' => [
            'class' => Render::class
        ]

    ]
];