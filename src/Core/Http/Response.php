<?php
/**
 * HTTP Response Helper
 * 
 * Provides methods for sending HTTP responses.
 */

namespace EcoTech\Core\Http;

class Response
{
    /**
     * Send a JSON response
     */
    public static function json(array $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    /**
     * Send a success JSON response
     */
    public static function success(array $data = [], string $message = ''): void
    {
        self::json(array_merge(['success' => true, 'message' => $message], $data));
    }

    /**
     * Send an error JSON response
     */
    public static function error(string $message, int $statusCode = 400): void
    {
        self::json(['success' => false, 'message' => $message], $statusCode);
    }

    /**
     * Redirect to a URL
     */
    public static function redirect(string $url): void
    {
        header("Location: $url");
        exit;
    }

    /**
     * Redirect with a flash message
     */
    public static function redirectWithMessage(string $url, string $message, string $type = 'info'): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['flash_message'] = $message;
        $_SESSION['flash_type'] = $type;
        self::redirect($url);
    }

    /**
     * Set HTTP status code
     */
    public static function status(int $code): void
    {
        http_response_code($code);
    }

    /**
     * Set a response header
     */
    public static function header(string $name, string $value): void
    {
        header("$name: $value");
    }

    /**
     * Send method not allowed response
     */
    public static function methodNotAllowed(): void
    {
        self::error('Method not allowed', 405);
    }

    /**
     * Send not found response
     */
    public static function notFound(string $message = 'Not found'): void
    {
        self::error($message, 404);
    }
}
