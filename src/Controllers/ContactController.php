<?php

namespace App\Controllers;

use App\View;

class ContactController
{
    public function index(): void
    {
        View::renderWithLayout('pages/contact', [
            'title' => 'Contact Us - EcoTech Solutions'
        ]);
    }
    
    public function submit(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /contact');
            exit;
        }
        
        // Handle form submission
        $name = htmlspecialchars($_POST['name'] ?? '');
        $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
        $message = htmlspecialchars($_POST['message'] ?? '');
        
        // Here you would save to database or send email
        // For now, just redirect with success
        
        header('Location: /contact?success=1');
        exit;
    }
}
