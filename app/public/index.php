<?php

use Simplemvc\ControllerDummy\DummyController;
use Simplemvc\Core\Request;
use Simplemvc\Core\Router\Route;
use Simplemvc\Core\Router\RouteCollection;
use Simplemvc\Core\Router\Router;

define("APP_PATH", dirname(__DIR__));

require_once APP_PATH . DIRECTORY_SEPARATOR . 'bootstrap.php';

$request = Request::init();
$router = new Router(new RouteCollection());

$router->addRoute(Route::new(''));
$router->addRoute(Route::new('add-message/{message:\w+}')->setAction('addMessage'));
$router->addRouteGroup([
    Route::new(),
    Route::new('test-page/{welcome:\w+}')->setAction('testPage')
], 'dummy', DummyController::class);

$router->dispatch($request);