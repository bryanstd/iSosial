<?php

namespace App\Controllers;

use App\Controller;

class AuthController extends Controller
{
    public function login()
    {
        $this->render('login');
    }

    public function register()
    {
        $this->render('register');
    }
}