<?php
/**
 * Authentication Service
 * 
 * Handles user authentication, session management, and security functions.
 */

namespace EcoTech\Modules\Auth;

class AuthService
{
    /**
     * Start session if not already started
     */
    public static function startSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Check if user is logged in
     */
    public static function isLoggedIn(): bool
    {
        self::startSession();
        return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
    }

    /**
     * Get current user data
     */
    public static function getCurrentUser(): ?array
    {
        if (!self::isLoggedIn()) {
            return null;
        }
        return [
            'id' => $_SESSION['user_id'],
            'name' => $_SESSION['user_name'] ?? '',
            'email' => $_SESSION['user_email'] ?? ''
        ];
    }

    /**
     * Hash password securely
     */
    public static function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * Verify password against hash
     */
    public static function verifyPassword(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }

    /**
     * Login user - set session data
     */
    public static function loginUser(int $userId, string $userName, string $userEmail): void
    {
        self::startSession();
        $_SESSION['user_id'] = $userId;
        $_SESSION['user_name'] = $userName;
        $_SESSION['user_email'] = $userEmail;
        $_SESSION['login_time'] = time();
    }

    /**
     * Logout user - clear session
     */
    public static function logoutUser(): void
    {
        self::startSession();
        session_unset();
        session_destroy();
    }

    /**
     * Generate CSRF token
     */
    public static function generateCSRFToken(): string
    {
        self::startSession();
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    /**
     * Verify CSRF token
     */
    public static function verifyCSRFToken(string $token): bool
    {
        self::startSession();
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }

    /**
     * Sanitize user input
     */
    public static function sanitizeInput(string $input): string
    {
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Validate email format
     */
    public static function isValidEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Redirect with flash message
     */
    public static function redirectWithMessage(string $url, string $message, string $type = 'info'): void
    {
        self::startSession();
        $_SESSION['flash_message'] = $message;
        $_SESSION['flash_type'] = $type;
        header("Location: $url");
        exit;
    }

    /**
     * Get and clear flash message
     */
    public static function getFlashMessage(): ?array
    {
        self::startSession();
        if (isset($_SESSION['flash_message'])) {
            $message = [
                'text' => $_SESSION['flash_message'],
                'type' => $_SESSION['flash_type'] ?? 'info'
            ];
            unset($_SESSION['flash_message'], $_SESSION['flash_type']);
            return $message;
        }
        return null;
    }

    /**
     * Require authentication - redirect if not logged in
     */
    public static function requireAuth(string $redirectUrl = 'login.php', string $message = 'Please sign in to access this page.'): void
    {
        if (!self::isLoggedIn()) {
            self::redirectWithMessage($redirectUrl, $message, 'info');
        }
    }

    /**
     * Require guest - redirect if logged in
     */
    public static function requireGuest(string $redirectUrl = 'dashboard.php'): void
    {
        if (self::isLoggedIn()) {
            header("Location: $redirectUrl");
            exit;
        }
    }
}
