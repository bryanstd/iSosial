<?php

namespace App\Controllers;

use App\Controller;
use App\Models\UserModel;

class AuthController extends Controller
{
    private $userModel;
    
    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function showLoginPage()
    {
        $this->render('/auth/login');
    }

    public function showRegisterPage()
    {
        $this->render('/auth/register');
    }

    public function processLogin() {
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        $user = $this->userModel->login($email, $password);

        if ($user) {
            $this->redirect("/dashboard");
        } else {
            $this->render('/auth/login', ['error' => 'Email atau password salah, silakan coba lagi!']);
        }
    }

    public function processRegister() {
        if (!$_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->redirect('/register');
        }
        $fullname = $_POST['fullname'];
        $phone = $_POST['phonenum'];
        $email = $_POST['email'];
        $password = md5($_POST['password']);

        $register = $this->userModel->register($fullname, $phone, $email, $password, "user");
        if ($register) {
            $this->redirect("/login");
        } else {
            $this->render('/auth/register');
        }
    }
}