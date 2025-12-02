<?php

namespace App\Controllers;

use App\View;

class HomeController
{
    public function index(): void
    {
        View::renderWithLayout('pages/home', [
            'title' => 'Home - EcoTech Solutions',
            'pageClass' => 'home-page'
        ]);
    }
}
