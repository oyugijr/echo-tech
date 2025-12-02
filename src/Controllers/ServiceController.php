<?php

namespace App\Controllers;

use App\View;
use App\Database;

class ServiceController
{
    public function index(): void
    {
        $pdo = Database::getConnection();
        
        // Fetch services from database
        $stmt = $pdo->query("SELECT * FROM services ORDER BY id ASC");
        $services = $stmt->fetchAll();
        
        View::renderWithLayout('pages/services', [
            'title' => 'Our Services - EcoTech Solutions',
            'services' => $services
        ]);
    }
}
