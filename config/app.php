<?php

return [
    'name' => $_ENV['APP_NAME'] ?? 'EcoTech Solutions',
    'env' => $_ENV['APP_ENV'] ?? 'production',
    'debug' => $_ENV['APP_DEBUG'] ?? false,
    'url' => $_ENV['APP_URL'] ?? 'http://localhost:8000',
    
    'site' => [
        'email' => $_ENV['SITE_EMAIL'] ?? 'info@ecotechsolutions.com',
        'phone' => $_ENV['SITE_PHONE'] ?? '',
        'address' => $_ENV['SITE_ADDRESS'] ?? '',
    ],
    
    'session' => [
        'name' => 'ecotech_session',
        'lifetime' => 120, // minutes
        'path' => '/',
        'domain' => null,
        'secure' => false,
        'httponly' => true,
    ],
    
    'paths' => [
        'templates' => __DIR__ . '/../templates',
        'public' => __DIR__ . '/../public',
        'storage' => __DIR__ . '/../storage',
    ]
];
