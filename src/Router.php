<?php

namespace App;

class Router
{
    private array $routes = [];
    
    public function __construct()
    {
        $this->routes = require __DIR__ . '/../config/routes.php';
    }
    
    public function dispatch(string $uri): void
    {
        // Remove query string
        $uri = parse_url($uri, PHP_URL_PATH);
        
        // Remove trailing slash
        $uri = rtrim($uri, '/');
        if ($uri === '') {
            $uri = '/';
        }
        
        // Find matching route
        if (!isset($this->routes[$uri])) {
            $this->notFound();
            return;
        }
        
        $route = $this->routes[$uri];
        
        // Check middleware
        if (isset($route['middleware']) && $route['middleware'] === 'auth') {
            session_start();
            if (!isset($_SESSION['user_id'])) {
                header('Location: /login');
                exit;
            }
        }
        
        // Dispatch to controller
        $controllerClass = 'App\\Controllers\\' . $route['controller'];
        $method = $route['method'];
        
        if (!class_exists($controllerClass)) {
            $this->error500("Controller not found: $controllerClass");
            return;
        }
        
        $controller = new $controllerClass();
        
        if (!method_exists($controller, $method)) {
            $this->error500("Method not found: $method");
            return;
        }
        
        $controller->$method();
    }
    
    private function notFound(): void
    {
        http_response_code(404);
        echo "404 - Page Not Found";
    }
    
    private function error500(string $message): void
    {
        http_response_code(500);
        echo "500 - Internal Server Error: $message";
    }
}
