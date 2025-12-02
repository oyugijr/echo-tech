<?php

namespace App\Controllers;

use App\View;
use App\Database;

class ProjectController
{
    public function index(): void
    {
        $pdo = Database::getConnection();
        
        // Fetch projects from database
        $stmt = $pdo->query("SELECT * FROM projects ORDER BY created_at DESC");
        $projects = $stmt->fetchAll();
        
        View::renderWithLayout('pages/projects', [
            'title' => 'Our Projects - EcoTech Solutions',
            'projects' => $projects
        ]);
    }
}
