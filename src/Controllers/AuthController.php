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
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/login');
            return;
        }
        
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        
        if (empty($email) || empty($password)) {
            $this->render('/auth/login', ['error' => 'Email dan password harus diisi!']);
            return;
        }
        
        $user = $this->userModel->login($email, $password);

        if ($user) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['full_name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['role'] ?? 'user';
            
            $this->redirect("/dashboard");
        } else {
            $this->render('/auth/login', ['error' => 'Email atau password salah, silakan coba lagi!']);
        }
    }

    public function processRegister() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/register');
            return;
        }
        
        $fullname = trim($_POST['fullname'] ?? '');
        $phone = trim($_POST['phonenum'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        
        $errors = [];
        if (empty($fullname)) {
            $errors[] = 'Nama lengkap harus diisi';
        }
        if (empty($phone)) {
            $errors[] = 'Nomor telepon harus diisi';
        }
        if (empty($email)) {
            $errors[] = 'Email harus diisi';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Format email tidak valid';
        }
        if (empty($password)) {
            $errors[] = 'Password harus diisi';
        }
        
        if (!empty($errors)) {
            $this->render('/auth/register', [
                'errors' => $errors,
                'old_input' => [
                    'fullname' => $fullname,
                    'phonenum' => $phone,
                    'email' => $email
                ]
            ]);
            return;
        }
        
        $hashedPassword = md5($password);
        $register = $this->userModel->register($fullname, $phone, $email, $hashedPassword, "user");
        
        if (is_array($register) && isset($register['success']) && $register['success'] === true) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['flash_message'] = 'Pendaftaran berhasil! Silakan login.';
            $this->redirect('/login');
        } else {
            $errorMessage = is_array($register) && isset($register['error']) 
                ? $register['error'] 
                : 'Registrasi gagal, silakan coba lagi';
            
            $this->render('/auth/register', [
                'error' => $errorMessage,
                'old_input' => [
                    'fullname' => $fullname,
                    'phonenum' => $phone,
                    'email' => $email
                ]
            ]);
        }
    }
    
    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        session_destroy();
        $this->redirect('/login');
    }
}
