<?php

namespace App\Controllers\Api;

use App\Database;

class SubscribeController
{
    public function subscribe(): void
    {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            exit;
        }
        
        $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['success' => false, 'message' => 'Valid email is required']);
            exit;
        }
        
        try {
            $pdo = Database::getConnection();
            
            // Check if already subscribed
            $stmt = $pdo->prepare("SELECT id FROM newsletter_subscribers WHERE email = ?");
            $stmt->execute([$email]);
            
            if ($stmt->fetch()) {
                echo json_encode(['success' => false, 'message' => 'Email already subscribed']);
                exit;
            }
            
            // Subscribe
            $stmt = $pdo->prepare("INSERT INTO newsletter_subscribers (email, subscribed_at) VALUES (?, NOW())");
            $stmt->execute([$email]);
            
            echo json_encode([
                'success' => true,
                'message' => 'Thank you for subscribing!'
            ]);
        } catch (\Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Subscription failed. Please try again.'
            ]);
        }
    }
}
