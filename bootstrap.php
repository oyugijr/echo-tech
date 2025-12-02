<?php
/**
 * Application Bootstrap
 * 
 * Initializes the application and provides helper functions for backward compatibility.
 * Include this file at the top of your PHP pages to use the modular architecture.
 */

// Load Composer autoloader
require_once __DIR__ . '/vendor/autoload.php';

use EcoTech\Core\Application;
use EcoTech\Modules\Auth\AuthService;

// Initialize the application
$app = Application::getInstance(__DIR__);
$app->boot();

// Get PDO instance for backward compatibility
$pdo = $app->pdo();
$db_error = $app->database()?->getError();

// ============================================================================
// Backward Compatibility Functions
// These functions maintain compatibility with existing code while using
// the new modular architecture internally.
// ============================================================================

/**
 * Check if user is logged in
 */
function isLoggedIn(): bool
{
    return AuthService::isLoggedIn();
}

/**
 * Get current user data
 */
function getCurrentUser(): ?array
{
    return AuthService::getCurrentUser();
}

/**
 * Hash password securely
 */
function hashPassword(string $password): string
{
    return AuthService::hashPassword($password);
}

/**
 * Verify password
 */
function verifyPassword(string $password, string $hash): bool
{
    return AuthService::verifyPassword($password, $hash);
}

/**
 * Login user
 */
function loginUser(int $userId, string $userName, string $userEmail): void
{
    AuthService::loginUser($userId, $userName, $userEmail);
}

/**
 * Logout user
 */
function logoutUser(): void
{
    AuthService::logoutUser();
}

/**
 * Generate CSRF token
 */
function generateCSRFToken(): string
{
    return AuthService::generateCSRFToken();
}

/**
 * Verify CSRF token
 */
function verifyCSRFToken(string $token): bool
{
    return AuthService::verifyCSRFToken($token);
}

/**
 * Sanitize input
 */
function sanitizeInput(string $input): string
{
    return AuthService::sanitizeInput($input);
}

/**
 * Validate email format
 */
function isValidEmail(string $email): bool
{
    return AuthService::isValidEmail($email);
}

/**
 * Redirect with message
 */
function redirectWithMessage(string $url, string $message, string $type = 'info'): void
{
    AuthService::redirectWithMessage($url, $message, $type);
}

/**
 * Get and clear flash message
 */
function getFlashMessage(): ?array
{
    return AuthService::getFlashMessage();
}
