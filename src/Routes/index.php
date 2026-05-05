<?php

use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Router;

$router = new Router();

$router->get('/', HomeController::class, 'index');
$router->get('/homepage2', HomeController::class, 'indexPage2');
$router->get('/aboutme', HomeController::class, 'aboutme');

$router->get('/login', AuthController::class, 'showLoginPage');
$router->post('/login', AuthController::class, 'processLogin');

$router->get('/register', AuthController::class, 'showRegisterPage');
$router->post('/register', AuthController::class, 'processRegister');

$router->get('/dashboard', DashboardController::class, 'index');
$router->get('/dashboard/kegiatan', DashboardController::class, 'kegiatanIndex');
$router->get('/dashboard/riwayat', DashboardController::class, 'riwayatIndex');
$router->get('/dashboard/profile', DashboardController::class, 'profile');
$router->get('/dashboard/settings', DashboardController::class, 'settings');
$router->get('/dashboard/admin', DashboardController::class, 'adminPanel');
$router->get('/dashboard/admin/users', DashboardController::class, 'adminUsers');
$router->post('/dashboard/admin/users/save', DashboardController::class, 'adminUserSave');
$router->post('/dashboard/admin/users/delete', DashboardController::class, 'adminUserDelete');
$router->get('/dashboard/relawan', DashboardController::class, 'relawanIndex');
$router->post('/dashboard/relawan/save', DashboardController::class, 'relawanSave');
$router->post('/dashboard/relawan/delete', DashboardController::class, 'relawanDelete');
$router->get('/logout', AuthController::class, 'logout');

$router->dispatch();
