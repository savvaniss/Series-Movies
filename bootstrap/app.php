<?php
//error_reporting(E_ERROR | E_WARNING | E_PARSE);

use Respect\Validation\Validator as v;
use Noodlehaus\Config;

session_start();

require __DIR__ . '/../vendor/autoload.php';

$config = new Config(__DIR__ . '/../app/config');

$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true,
        'db' => [
            'driver' => $config->get('mysql.driver'),
            'host' => $config->get('mysql.host'),
            'database'  => $config->get('mysql.database'),
            'username'  => $config->get('mysql.username'),
            'password'  => $config->get('mysql.password'),
            'charset'   => $config->get('mysql.charset'),
            'collation' => $config->get('mysql.collation'),
            'prefix'    => $config->get('mysql.prefix'),
        ],
        'determineRouteBeforeAppMiddleware' => true
    ],
]);

$container = $app->getContainer();

$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = function ($container) use ($capsule){
    return $capsule;
};

$container['auth'] = function ($container){
    return new \App\Auth\Auth;
};

$container['msg'] = function ($container){
    return new \App\Services\Mailer;
};

$container['flash'] = function ($container){
    return new \Slim\Flash\Messages;
};

$container['view'] = function($container){
    $view = new \Slim\Views\Twig(__DIR__ . '/../resources/views',[
        'cache' => false,
        'debug' => true
    ]);
    $view->addExtension(new Twig_Extension_Debug());
    $view->addExtension(new \Slim\Views\TwigExtension(
        $container->router,
        $container->request->getUri()
    ));
    $view->getEnvironment()->addGlobal('auth', [
        'check' => $container->auth->check(),
        'user' => $container->auth->user(),
    ]);
    $view->getEnvironment()->addGlobal('flash', $container->flash);
    return $view;
};

$container['notFoundHandler']= function($container){
    return function ($request, $response) use ($container){
        return $container['view']->render($response->withStatus(404),'404.twig',[
            "url"=>$_SERVER['REQUEST_URI']
            ]);
    };
};

$container['validator'] = function ($container){
    return new App\Validation\Validator;
};

$container['HomeController'] = function ($container){
    return new \App\Controllers\HomeController($container);
};

$container['AuthController'] = function ($container){
    return new \App\Controllers\Auth\AuthController($container);
};

$container['PasswordController'] = function ($container){
    return new \App\Controllers\Auth\PasswordController($container);
};

$container['UsersController'] = function ($container){
    return new \App\Controllers\Admin\UsersController($container);
};

$container['csrf'] = function ($container){
    return new \Slim\Csrf\Guard;
};

$container['SeriesController'] = function ($container){
    return new \App\Controllers\SeriesController($container);
};

$container['FileController'] = function ($container){
    return new \App\Controllers\FileController($container);
};

$container['slug'] = function ($container) {
    return new \Cocur\Slugify\Slugify;
};

$container['carbon']= function($container){
    return new \Carbon\Carbon;
};

$app->add(new \App\Middleware\RouteMiddleware($container));
$app->add(new \App\Middleware\ValidationErrorsMiddleware($container));
$app->add(new \App\Middleware\OldInputMiddleware($container));
$app->add(new \App\Middleware\CsrfViewMiddleware($container));

$app->add($container->csrf);

v::with('App\\Validation\\Rules\\');

require __DIR__ . '/../app/routes.php';
