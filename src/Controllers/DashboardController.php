<?php
namespace App\Controllers;

class DashboardController extends BaseController
{
    public function index()
    {
        $this->render('/dashboard/index', ['user' => $this->user]);
    }

    public function profile()
    {
        $this->render('/dashboard/profile', ['user' => $this->user]);
    }
    
    // Admin only method example
    public function adminPanel()
    {
        $this->requireAdmin(); // This will check if user is admin
        $this->render('/dashboard/admin', ['user' => $this->user]);
    }
}