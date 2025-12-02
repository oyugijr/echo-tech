<?php
/**
 * Configuration File
 * 
 * This file provides backward compatibility by delegating to the Core Config module.
 * For new code, use the Application instance and its config() method.
 */

require_once __DIR__ . '/../bootstrap.php';

use EcoTech\Core\Application;

$app = Application::getInstance();

return [
    'database' => [
        'host' => $app->config()->get('database.host', 'localhost'),
        'dbname' => $app->config()->get('database.name', 'ecotech'),
        'user' => $app->config()->get('database.user', 'root'),
        'pass' => $app->config()->get('database.pass', '')
    ],
    'site' => [
        'name' => $app->config()->get('site.name', 'EcoTech Solutions'),
        'email' => $app->config()->get('site.email', 'info@ecotechsolutions.com')
    ]
];