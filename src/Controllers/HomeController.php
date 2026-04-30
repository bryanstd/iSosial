<?php

namespace App\Controllers;

use App\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $this->render('index');
    }

    public function indexPage2()
    {
        $this->render('index2');
    }

    public function aboutme()
    {
        $this->render('aboutme');
    }
}