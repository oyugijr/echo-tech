<?php
/**
 * Authentication Controller
 * 
 * Handles login, registration, logout, and dashboard functionality.
 */

namespace EcoTech\Modules\Auth\Controllers;

use EcoTech\Core\Http\Controller;
use EcoTech\Modules\Auth\AuthService;

class AuthController extends Controller
{
    /**
     * Display login page and handle login
     */
    public function login(): void
    {
        // Redirect if already logged in
        AuthService::requireGuest();

        $error = '';
        $success = '';
        $email = '';

        // Get flash message
        $flash = AuthService::getFlashMessage();
        if ($flash) {
            if ($flash['type'] === 'success') {
                $success = $flash['text'];
            } else {
                $error = $flash['text'];
            }
        }

        // Handle form submission
        if ($this->request->isPost()) {
            $email = AuthService::sanitizeInput($this->request->input('email', ''));
            $password = $this->request->input('password', '');
            $csrf_token = $this->request->input('csrf_token', '');

            if (!AuthService::verifyCSRFToken($csrf_token)) {
                $error = 'Invalid request. Please try again.';
            } elseif (empty($email) || empty($password)) {
                $error = 'Please fill in all fields.';
            } elseif (!AuthService::isValidEmail($email)) {
                $error = 'Please enter a valid email address.';
            } else {
                $pdo = $this->pdo();
                if (!$pdo) {
                    $error = 'Database connection unavailable. Please try again later.';
                } else {
                    try {
                        $stmt = $pdo->prepare("SELECT id, name, email, password FROM users WHERE email = ?");
                        $stmt->execute([$email]);
                        $user = $stmt->fetch();

                        if ($user && AuthService::verifyPassword($password, $user['password'])) {
                            AuthService::loginUser($user['id'], $user['name'], $user['email']);
                            $this->redirect('dashboard.php');
                        } else {
                            $error = 'Invalid email or password.';
                        }
                    } catch (\PDOException $e) {
                        $error = 'An error occurred. Please try again later.';
                    }
                }
            }
        }

        // Pass variables to view
        $this->renderLoginView($error, $success, $email);
    }

    /**
     * Display registration page and handle registration
     */
    public function register(): void
    {
        // Redirect if already logged in
        AuthService::requireGuest();

        $error = '';
        $name = '';
        $email = '';

        // Handle form submission
        if ($this->request->isPost()) {
            $name = AuthService::sanitizeInput($this->request->input('name', ''));
            $email = AuthService::sanitizeInput($this->request->input('email', ''));
            $password = $this->request->input('password', '');
            $confirm_password = $this->request->input('confirm_password', '');
            $csrf_token = $this->request->input('csrf_token', '');

            if (!AuthService::verifyCSRFToken($csrf_token)) {
                $error = 'Invalid request. Please try again.';
            } elseif (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
                $error = 'Please fill in all fields.';
            } elseif (strlen($name) < 2 || strlen($name) > 100) {
                $error = 'Name must be between 2 and 100 characters.';
            } elseif (!AuthService::isValidEmail($email)) {
                $error = 'Please enter a valid email address.';
            } elseif (strlen($password) < 8) {
                $error = 'Password must be at least 8 characters long.';
            } elseif ($password !== $confirm_password) {
                $error = 'Passwords do not match.';
            } else {
                $pdo = $this->pdo();
                if (!$pdo) {
                    $error = 'Database connection unavailable. Please try again later.';
                } else {
                    try {
                        // Check if email already exists
                        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
                        $stmt->execute([$email]);

                        if ($stmt->fetch()) {
                            $error = 'An account with this email already exists.';
                        } else {
                            // Create new user
                            $hashedPassword = AuthService::hashPassword($password);
                            $stmt = $pdo->prepare("INSERT INTO users (name, email, password, created_at) VALUES (?, ?, ?, NOW())");
                            $stmt->execute([$name, $email, $hashedPassword]);

                            AuthService::redirectWithMessage('login.php', 'Account created successfully! Please sign in.', 'success');
                        }
                    } catch (\PDOException $e) {
                        $error = 'An error occurred. Please try again later.';
                    }
                }
            }
        }

        // Pass variables to view
        $this->renderRegisterView($error, $name, $email);
    }

    /**
     * Handle logout
     */
    public function logout(): void
    {
        AuthService::logoutUser();
        AuthService::redirectWithMessage('login.php', 'You have been signed out successfully.', 'success');
    }

    /**
     * Display dashboard page
     */
    public function dashboard(): void
    {
        // Require authentication
        AuthService::requireAuth('login.php', 'Please sign in to access your dashboard.');

        $user = AuthService::getCurrentUser();
        $inquiries = [];

        $pdo = $this->pdo();
        if ($pdo) {
            try {
                $stmt = $pdo->prepare("SELECT * FROM inquiries WHERE user_id = ? ORDER BY created_at DESC LIMIT 5");
                $stmt->execute([$user['id']]);
                $inquiries = $stmt->fetchAll();
            } catch (\PDOException $e) {
                // Table might not exist yet
            }
        }

        // Pass variables to view
        $this->renderDashboardView($user, $inquiries);
    }

    /**
     * Render login view (helper to include the view file)
     */
    private function renderLoginView(string $error, string $success, string $email): void
    {
        // Make variables available to the view
        $generateCSRFToken = [AuthService::class, 'generateCSRFToken'];
        include $this->app->publicPath('login.php');
    }

    /**
     * Render register view
     */
    private function renderRegisterView(string $error, string $name, string $email): void
    {
        $generateCSRFToken = [AuthService::class, 'generateCSRFToken'];
        include $this->app->publicPath('register.php');
    }

    /**
     * Render dashboard view
     */
    private function renderDashboardView(array $user, array $inquiries): void
    {
        include $this->app->publicPath('dashboard.php');
    }
}
