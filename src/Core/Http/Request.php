<?php
/**
 * HTTP Request Wrapper
 * 
 * Provides a clean interface for accessing HTTP request data.
 */

namespace EcoTech\Core\Http;

class Request
{
    private array $get;
    private array $post;
    private array $server;
    private array $cookies;
    private array $files;
    private ?array $json = null;

    public function __construct()
    {
        $this->get = $_GET;
        $this->post = $_POST;
        $this->server = $_SERVER;
        $this->cookies = $_COOKIE;
        $this->files = $_FILES;
    }

    /**
     * Get request method
     */
    public function method(): string
    {
        return strtoupper($this->server['REQUEST_METHOD'] ?? 'GET');
    }

    /**
     * Check if request is a specific method
     */
    public function isMethod(string $method): bool
    {
        return $this->method() === strtoupper($method);
    }

    /**
     * Check if request is POST
     */
    public function isPost(): bool
    {
        return $this->isMethod('POST');
    }

    /**
     * Check if request is GET
     */
    public function isGet(): bool
    {
        return $this->isMethod('GET');
    }

    /**
     * Check if request is AJAX
     */
    public function isAjax(): bool
    {
        return ($this->server['HTTP_X_REQUESTED_WITH'] ?? '') === 'XMLHttpRequest';
    }

    /**
     * Get a query parameter (GET)
     */
    public function query(string $key, mixed $default = null): mixed
    {
        return $this->get[$key] ?? $default;
    }

    /**
     * Get a POST parameter
     */
    public function input(string $key, mixed $default = null): mixed
    {
        return $this->post[$key] ?? $default;
    }

    /**
     * Get all POST parameters
     */
    public function all(): array
    {
        return $this->post;
    }

    /**
     * Get JSON body data
     */
    public function json(string $key = null, mixed $default = null): mixed
    {
        if ($this->json === null) {
            $body = file_get_contents('php://input');
            $this->json = json_decode($body, true) ?? [];
        }

        if ($key === null) {
            return $this->json;
        }

        return $this->json[$key] ?? $default;
    }

    /**
     * Get a sanitized input value
     */
    public function sanitized(string $key, mixed $default = null): mixed
    {
        $value = $this->input($key) ?? $this->query($key) ?? $default;
        
        if (is_string($value)) {
            return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
        }
        
        return $value;
    }

    /**
     * Get uploaded file
     */
    public function file(string $key): ?array
    {
        return $this->files[$key] ?? null;
    }

    /**
     * Get server variable
     */
    public function server(string $key, mixed $default = null): mixed
    {
        return $this->server[$key] ?? $default;
    }

    /**
     * Get request URI
     */
    public function uri(): string
    {
        return $this->server['REQUEST_URI'] ?? '/';
    }

    /**
     * Get request path (without query string)
     */
    public function path(): string
    {
        $uri = $this->uri();
        $position = strpos($uri, '?');
        return $position !== false ? substr($uri, 0, $position) : $uri;
    }
}
