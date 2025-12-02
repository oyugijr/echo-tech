<?php

/**
 * EcoTech Solutions - Front Controller
 * 
 * This is the single entry point for the application.
 * All requests are routed through this file.
 */

// Start session
session_start();

// Load Composer's autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Error handling
if ($_ENV['APP_ENV'] === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Initialize router
$router = new App\Router();

// Get the request URI
$uri = $_SERVER['REQUEST_URI'];

// Dispatch the request
try {
    $router->dispatch($uri);
} catch (Exception $e) {
    if ($_ENV['APP_ENV'] === 'development') {
        echo '<h1>Error</h1>';
        echo '<pre>' . $e->getMessage() . '</pre>';
        echo '<pre>' . $e->getTraceAsString() . '</pre>';
    } else {
        http_response_code(500);
        echo '500 - Internal Server Error';
    }
}
