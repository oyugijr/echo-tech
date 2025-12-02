<?php

namespace App\Controllers;

use App\View;
use App\Database;

class AuthController
{
    public function login(): void
    {
        session_start();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'] ?? '';
            
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();
            
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_name'] = $user['name'];
                
                header('Location: /dashboard');
                exit;
            }
            
            $error = 'Invalid email or password';
            View::render('pages/login', [
                'title' => 'Login - EcoTech Solutions',
                'error' => $error
            ]);
            return;
        }
        
        View::render('pages/login', [
            'title' => 'Login - EcoTech Solutions'
        ]);
    }
    
    public function register(): void
    {
        session_start();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = htmlspecialchars($_POST['name'] ?? '');
            $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
            
            // Validation
            $errors = [];
            
            if (empty($name)) {
                $errors[] = 'Name is required';
            }
            
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Valid email is required';
            }
            
            if (strlen($password) < 8) {
                $errors[] = 'Password must be at least 8 characters';
            }
            
            if ($password !== $confirmPassword) {
                $errors[] = 'Passwords do not match';
            }
            
            if (empty($errors)) {
                $pdo = Database::getConnection();
                
                // Check if email exists
                $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
                $stmt->execute([$email]);
                if ($stmt->fetch()) {
                    $errors[] = 'Email already registered';
                } else {
                    // Create user
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $pdo->prepare("INSERT INTO users (name, email, password, created_at) VALUES (?, ?, ?, NOW())");
                    $stmt->execute([$name, $email, $hashedPassword]);
                    
                    header('Location: /login');
                    exit;
                }
            }
            
            View::render('pages/register', [
                'title' => 'Register - EcoTech Solutions',
                'errors' => $errors
            ]);
            return;
        }
        
        View::render('pages/register', [
            'title' => 'Register - EcoTech Solutions'
        ]);
    }
    
    public function logout(): void
    {
        session_start();
        session_destroy();
        header('Location: /');
        exit;
    }
}
