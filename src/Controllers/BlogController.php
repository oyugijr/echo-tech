<?php

namespace App\Controllers;

use App\View;
use App\Database;

class BlogController
{
    public function index(): void
    {
        $pdo = Database::getConnection();
        
        // Get blog posts with pagination
        $page = $_GET['page'] ?? 1;
        $perPage = 10;
        $offset = ($page - 1) * $perPage;
        
        $stmt = $pdo->prepare("SELECT * FROM blog_posts ORDER BY created_at DESC LIMIT ? OFFSET ?");
        $stmt->execute([$perPage, $offset]);
        $posts = $stmt->fetchAll();
        
        // Get total count for pagination
        $totalStmt = $pdo->query("SELECT COUNT(*) FROM blog_posts");
        $total = $totalStmt->fetchColumn();
        $totalPages = ceil($total / $perPage);
        
        View::renderWithLayout('pages/blog', [
            'title' => 'Blog - EcoTech Solutions',
            'posts' => $posts,
            'currentPage' => $page,
            'totalPages' => $totalPages
        ]);
    }
    
    public function show(): void
    {
        $id = $_GET['id'] ?? null;
        
        if (!$id) {
            header('Location: /blog');
            exit;
        }
        
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM blog_posts WHERE id = ?");
        $stmt->execute([$id]);
        $post = $stmt->fetch();
        
        if (!$post) {
            header('Location: /blog');
            exit;
        }
        
        View::renderWithLayout('pages/blog-post', [
            'title' => $post['title'] . ' - EcoTech Solutions',
            'post' => $post
        ]);
    }
}
