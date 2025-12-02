<?php

return [
    // Public routes
    '/' => ['controller' => 'HomeController', 'method' => 'index'],
    '/home' => ['controller' => 'HomeController', 'method' => 'index'],
    '/about' => ['controller' => 'PageController', 'method' => 'about'],
    '/services' => ['controller' => 'ServiceController', 'method' => 'index'],
    '/projects' => ['controller' => 'ProjectController', 'method' => 'index'],
    '/contact' => ['controller' => 'ContactController', 'method' => 'index'],
    '/contact/submit' => ['controller' => 'ContactController', 'method' => 'submit'],
    '/blog' => ['controller' => 'BlogController', 'method' => 'index'],
    '/blog/post' => ['controller' => 'BlogController', 'method' => 'show'],
    '/search' => ['controller' => 'SearchController', 'method' => 'index'],
    '/privacy-policy' => ['controller' => 'PageController', 'method' => 'privacy'],
    '/terms' => ['controller' => 'PageController', 'method' => 'terms'],
    
    // Authentication routes
    '/login' => ['controller' => 'AuthController', 'method' => 'login'],
    '/register' => ['controller' => 'AuthController', 'method' => 'register'],
    '/logout' => ['controller' => 'AuthController', 'method' => 'logout'],
    
    // Protected routes (require authentication)
    '/dashboard' => ['controller' => 'DashboardController', 'method' => 'index', 'middleware' => 'auth'],
    
    // API routes
    '/api/search' => ['controller' => 'Api\SearchController', 'method' => 'search'],
    '/api/subscribe' => ['controller' => 'Api\SubscribeController', 'method' => 'subscribe'],
];
