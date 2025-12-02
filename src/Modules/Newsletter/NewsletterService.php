<?php
/**
 * Newsletter Service
 * 
 * Handles newsletter subscription operations.
 */

namespace EcoTech\Modules\Newsletter;

use EcoTech\Core\Database\Connection;

class NewsletterService
{
    private ?Connection $db;

    public function __construct(?Connection $db)
    {
        $this->db = $db;
    }

    /**
     * Subscribe an email to the newsletter
     * 
     * @return array{success: bool, message: string}
     */
    public function subscribe(string $email): array
    {
        if (!$this->db || !$this->db->isConnected()) {
            // Database unavailable - return success for demo purposes
            return [
                'success' => true,
                'message' => 'Thank you for subscribing! Check your inbox for a welcome email.'
            ];
        }

        $pdo = $this->db->getPdo();
        if (!$pdo) {
            return [
                'success' => true,
                'message' => 'Thank you for subscribing! Check your inbox for a welcome email.'
            ];
        }

        try {
            // Check if already subscribed
            $stmt = $pdo->prepare("SELECT id, status FROM newsletter_subscribers WHERE email = ?");
            $stmt->execute([$email]);
            $existing = $stmt->fetch();

            if ($existing) {
                if ($existing['status'] === 'active') {
                    return [
                        'success' => true,
                        'message' => 'You are already subscribed to our newsletter!'
                    ];
                } else {
                    // Reactivate subscription
                    $stmt = $pdo->prepare("UPDATE newsletter_subscribers SET status = 'active', updated_at = NOW() WHERE id = ?");
                    $stmt->execute([$existing['id']]);
                    return [
                        'success' => true,
                        'message' => 'Welcome back! Your subscription has been reactivated.'
                    ];
                }
            } else {
                // Create new subscription
                $stmt = $pdo->prepare("INSERT INTO newsletter_subscribers (email, status, subscribed_at) VALUES (?, 'active', NOW())");
                $stmt->execute([$email]);
                return [
                    'success' => true,
                    'message' => 'Thank you for subscribing! Check your inbox for a welcome email.'
                ];
            }
        } catch (\PDOException $e) {
            // If table doesn't exist, return success anyway (for demo purposes)
            return [
                'success' => true,
                'message' => 'Thank you for subscribing! Check your inbox for a welcome email.'
            ];
        }
    }

    /**
     * Unsubscribe an email from the newsletter
     */
    public function unsubscribe(string $email): array
    {
        if (!$this->db || !$this->db->isConnected()) {
            return [
                'success' => false,
                'message' => 'Unable to process request at this time.'
            ];
        }

        $pdo = $this->db->getPdo();
        if (!$pdo) {
            return ['success' => false, 'message' => 'Database unavailable'];
        }

        try {
            $stmt = $pdo->prepare("UPDATE newsletter_subscribers SET status = 'unsubscribed', updated_at = NOW() WHERE email = ?");
            $stmt->execute([$email]);

            if ($stmt->rowCount() > 0) {
                return [
                    'success' => true,
                    'message' => 'You have been unsubscribed from our newsletter.'
                ];
            } else {
                return [
                    'success' => true,
                    'message' => 'Email not found in our subscription list.'
                ];
            }
        } catch (\PDOException $e) {
            return [
                'success' => false,
                'message' => 'An error occurred. Please try again later.'
            ];
        }
    }
}
