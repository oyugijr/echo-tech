<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <title>Dashboard - EcoTech Solutions</title>
</head>
<body>
<?php 
require_once 'includes/auth.php';
require_once 'includes/db_connect.php';

// Require authentication
if (!isLoggedIn()) {
    redirectWithMessage('login.php', 'Please sign in to access your dashboard.', 'info');
}

$user = getCurrentUser();

// Get user's inquiries
$inquiries = [];
if ($pdo) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM inquiries WHERE user_id = ? ORDER BY created_at DESC LIMIT 5");
        $stmt->execute([$user['id']]);
        $inquiries = $stmt->fetchAll();
    } catch (PDOException $e) {
        // Table might not exist yet
    }
}

include 'includes/header.php';
?>

<main class="dashboard-page">
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1>Welcome, <?= htmlspecialchars($user['name']) ?>!</h1>
            <p class="dashboard-subtitle">Manage your account and track your project inquiries</p>
        </div>
        
        <div class="dashboard-grid">
            <!-- User Info Card -->
            <div class="dashboard-card user-card">
                <h2>Your Profile</h2>
                <div class="user-info">
                    <div class="user-avatar">
                        <?= strtoupper(substr($user['name'], 0, 1)) ?>
                    </div>
                    <div class="user-details">
                        <p class="user-name"><?= htmlspecialchars($user['name']) ?></p>
                        <p class="user-email"><?= htmlspecialchars($user['email']) ?></p>
                    </div>
                </div>
                <a href="logout.php" class="btn btn-secondary">Sign Out</a>
            </div>
            
            <!-- Quick Actions Card -->
            <div class="dashboard-card actions-card">
                <h2>Quick Actions</h2>
                <div class="actions-grid">
                    <a href="contact.php" class="action-item">
                        <span class="action-icon">📝</span>
                        <span>New Inquiry</span>
                    </a>
                    <a href="services.php" class="action-item">
                        <span class="action-icon">🔧</span>
                        <span>Our Services</span>
                    </a>
                    <a href="projects.php" class="action-item">
                        <span class="action-icon">📁</span>
                        <span>View Projects</span>
                    </a>
                    <a href="blog.php" class="action-item">
                        <span class="action-icon">📰</span>
                        <span>Latest News</span>
                    </a>
                </div>
            </div>
            
            <!-- Inquiries Card -->
            <div class="dashboard-card inquiries-card">
                <h2>Recent Inquiries</h2>
                <?php if (empty($inquiries)): ?>
                    <div class="empty-state">
                        <p>You haven't made any inquiries yet.</p>
                        <a href="contact.php" class="cta-button">Contact Us</a>
                    </div>
                <?php else: ?>
                    <div class="inquiries-list">
                        <?php foreach ($inquiries as $inquiry): ?>
                            <div class="inquiry-item">
                                <div class="inquiry-subject"><?= htmlspecialchars($inquiry['subject']) ?></div>
                                <div class="inquiry-date"><?= date('M j, Y', strtotime($inquiry['created_at'])) ?></div>
                                <div class="inquiry-status status-<?= $inquiry['status'] ?>">
                                    <?= ucfirst($inquiry['status']) ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Newsletter Card -->
            <div class="dashboard-card newsletter-card">
                <h2>Stay Updated</h2>
                <p>Subscribe to our newsletter for the latest sustainability tips and company updates.</p>
                <form class="newsletter-form" id="dashboardNewsletterForm">
                    <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" readonly>
                    <button type="submit" class="cta-button">Subscribe</button>
                </form>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
</body>
</html>
