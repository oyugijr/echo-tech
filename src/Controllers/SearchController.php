<?php

namespace App\Controllers;

use App\View;
use App\Database;

class SearchController
{
    public function index(): void
    {
        $query = $_GET['q'] ?? '';
        $results = [];
        
        if (!empty($query)) {
            $pdo = Database::getConnection();
            $searchTerm = "%$query%";
            
            // Search in blog posts
            $stmt = $pdo->prepare("SELECT 'blog' as type, id, title, excerpt as description FROM blog_posts WHERE title LIKE ? OR content LIKE ? LIMIT 10");
            $stmt->execute([$searchTerm, $searchTerm]);
            $results = array_merge($results, $stmt->fetchAll());
            
            // Search in services
            $stmt = $pdo->prepare("SELECT 'service' as type, id, name as title, description FROM services WHERE name LIKE ? OR description LIKE ? LIMIT 10");
            $stmt->execute([$searchTerm, $searchTerm]);
            $results = array_merge($results, $stmt->fetchAll());
            
            // Search in projects
            $stmt = $pdo->prepare("SELECT 'project' as type, id, title, description FROM projects WHERE title LIKE ? OR description LIKE ? LIMIT 10");
            $stmt->execute([$searchTerm, $searchTerm]);
            $results = array_merge($results, $stmt->fetchAll());
        }
        
        View::renderWithLayout('pages/search', [
            'title' => 'Search Results - EcoTech Solutions',
            'query' => $query,
            'results' => $results
        ]);
    }
}
