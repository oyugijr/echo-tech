<?php

namespace App\Controllers;

use App\View;

class PageController
{
    public function about(): void
    {
        View::renderWithLayout('pages/about', [
            'title' => 'About Us - EcoTech Solutions'
        ]);
    }
    
    public function privacy(): void
    {
        View::renderWithLayout('pages/privacy-policy', [
            'title' => 'Privacy Policy - EcoTech Solutions'
        ]);
    }
    
    public function terms(): void
    {
        View::renderWithLayout('pages/terms', [
            'title' => 'Terms & Conditions - EcoTech Solutions'
        ]);
    }
}
