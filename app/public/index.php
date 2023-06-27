<?php

use Simplemvc\Core\Request;
use Simplemvc\Core\Router\Route;
use Simplemvc\Core\Router\RouteCollection;
use Simplemvc\Core\Router\Router;

define("APP_PATH", dirname(__DIR__));

require_once APP_PATH . DIRECTORY_SEPARATOR . 'bootstrap.php';

$request = Request::init();
$router = new Router(new RouteCollection());
$router->addRoute(Route::new(''));
$router->addRoute(Route::new('about')->setAction('about'));
$router->addRoute(
    Route::new('dummy')
        ->setController('DummyController')
        ->setNamespace('Simplemvc\ControllerDummy')
);
$router->addRoute(
    Route::new('dummy/test-page/{welcome:\w+}')
        ->setController('DummyController')
        ->setAction('testPage')
        ->setNamespace('Simplemvc\ControllerDummy')
);
$router->dispatch($request);