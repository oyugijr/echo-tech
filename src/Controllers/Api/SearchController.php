<?php

namespace App\Controllers\Api;

use App\Database;

class SearchController
{
    public function search(): void
    {
        header('Content-Type: application/json');
        
        $query = $_GET['q'] ?? '';
        
        if (empty($query)) {
            echo json_encode(['success' => false, 'message' => 'Search query is required']);
            exit;
        }
        
        try {
            $pdo = Database::getConnection();
            $searchTerm = "%$query%";
            $results = [];
            
            // Search in blog posts
            $stmt = $pdo->prepare("SELECT 'blog' as type, id, title FROM blog_posts WHERE title LIKE ? LIMIT 5");
            $stmt->execute([$searchTerm]);
            $results = array_merge($results, $stmt->fetchAll());
            
            // Search in services
            $stmt = $pdo->prepare("SELECT 'service' as type, id, name as title FROM services WHERE name LIKE ? LIMIT 5");
            $stmt->execute([$searchTerm]);
            $results = array_merge($results, $stmt->fetchAll());
            
            echo json_encode([
                'success' => true,
                'results' => $results
            ]);
        } catch (\Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Search failed'
            ]);
        }
    }
}
