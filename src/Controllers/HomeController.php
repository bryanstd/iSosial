<?php

namespace App\Controllers;

use App\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $this->render('index');
    }

    public function aboutme()
    {
        $this->render('aboutme');
    }
}