<?php

use App\Controllers\HomeController;
use App\Controllers\LoginController;
use App\Router;

$router = new Router();

$router->get('/', HomeController::class, 'index');
$router->get('/login', LoginController::class, 'index');

$router->dispatch();