<?php
/**
 * View Helper
 * 
 * Provides utility functions for views.
 */

namespace EcoTech\Core\View;

class ViewHelper
{
    /**
     * Escape HTML special characters
     */
    public static function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Alias for escape
     */
    public static function e(string $value): string
    {
        return self::escape($value);
    }

    /**
     * Get and clear flash message
     */
    public static function getFlashMessage(): ?array
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

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
     * Generate CSRF token field for forms
     */
    public static function csrfField(): string
    {
        $token = self::generateCSRFToken();
        return '<input type="hidden" name="csrf_token" value="' . self::escape($token) . '">';
    }

    /**
     * Generate CSRF token
     */
    public static function generateCSRFToken(): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

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
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }

    /**
     * Format date for display
     */
    public static function formatDate(string $date, string $format = 'F j, Y'): string
    {
        return date($format, strtotime($date));
    }

    /**
     * Check if string contains substring (case-insensitive)
     */
    public static function strContains(string $haystack, string $needle): bool
    {
        return stripos($haystack, $needle) !== false;
    }
}
