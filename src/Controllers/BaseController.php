<?php
namespace App\Controllers;

use App\Controller;

abstract class BaseController extends Controller
{
    protected $user;
    
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
            exit();
        }

        $this->user = [
            'id' => $_SESSION['user_id'],
            'name' => $_SESSION['user_name'] ?? 'User',
            'email' => $_SESSION['user_email'] ?? '',
            'role' => $_SESSION['user_role'] ?? 'user'
        ];
    }
        
    protected function isAdmin()
    {
        return $this->user['role'] === 'admin';
    }
    
    protected function requireAdmin()
    {
        if (!$this->isAdmin()) {
            $this->render('/errors/403', ['message' => 'Hanya admin yang dapat mengakses halaman ini.']);
            exit();
        }
    }
}