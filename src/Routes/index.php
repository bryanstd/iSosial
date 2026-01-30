<?php

use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Router;

$router = new Router();

$router->get('/', HomeController::class, 'index');
$router->get('/dashboard', DashboardController::class, 'index');

$router->get('/login', AuthController::class, 'showLoginPage');
$router->post('/login', AuthController::class, 'processLogin');

$router->get('/register', AuthController::class, 'showRegisterPage');
$router->post('/register', AuthController::class, 'processRegister');

$router->dispatch();