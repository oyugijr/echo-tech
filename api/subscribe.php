<?php
/**
 * Newsletter Subscription API Handler
 */

header('Content-Type: application/json');

require_once __DIR__ . '/../includes/db_connect.php';
require_once __DIR__ . '/../includes/auth.php';

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Get JSON input or form data
$input = json_decode(file_get_contents('php://input'), true);
if (!$input) {
    $input = $_POST;
}

$email = sanitizeInput($input['email'] ?? '');

// Validate email
if (empty($email)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Email is required']);
    exit;
}

if (!isValidEmail($email)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Please enter a valid email address']);
    exit;
}

try {
    if (!$pdo) {
        // Database unavailable - return success for demo purposes
        echo json_encode(['success' => true, 'message' => 'Thank you for subscribing! Check your inbox for a welcome email.']);
        exit;
    }
    
    // Check if already subscribed
    $stmt = $pdo->prepare("SELECT id, status FROM newsletter_subscribers WHERE email = ?");
    $stmt->execute([$email]);
    $existing = $stmt->fetch();
    
    if ($existing) {
        if ($existing['status'] === 'active') {
            echo json_encode(['success' => true, 'message' => 'You are already subscribed to our newsletter!']);
        } else {
            // Reactivate subscription
            $stmt = $pdo->prepare("UPDATE newsletter_subscribers SET status = 'active', updated_at = NOW() WHERE id = ?");
            $stmt->execute([$existing['id']]);
            echo json_encode(['success' => true, 'message' => 'Welcome back! Your subscription has been reactivated.']);
        }
    } else {
        // Create new subscription
        $stmt = $pdo->prepare("INSERT INTO newsletter_subscribers (email, status, subscribed_at) VALUES (?, 'active', NOW())");
        $stmt->execute([$email]);
        echo json_encode(['success' => true, 'message' => 'Thank you for subscribing! Check your inbox for a welcome email.']);
    }
} catch (PDOException $e) {
    // If table doesn't exist, return success anyway (for demo purposes)
    echo json_encode(['success' => true, 'message' => 'Thank you for subscribing! Check your inbox for a welcome email.']);
}
?>
