<?php

namespace App\Controllers;

use App\View;

class DashboardController
{
    public function index(): void
    {
        session_start();
        
        View::renderWithLayout('pages/dashboard', [
            'title' => 'Dashboard - EcoTech Solutions',
            'userName' => $_SESSION['user_name'] ?? 'User'
        ]);
    }
}
