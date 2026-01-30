<?php

use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Router;

$router = new Router();

$router->get('/', HomeController::class, 'index');
$router->get('/login', AuthController::class, 'login');
$router->get('/register', AuthController::class, 'register');

$router->dispatch();