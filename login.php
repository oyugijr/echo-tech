<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/auth.css">
    <title>Login - EcoTech Solutions</title>
</head>
<body>
<?php 
require_once __DIR__ . '/bootstrap.php';

use EcoTech\Modules\Auth\AuthService;

// Redirect if already logged in
if (isLoggedIn()) {
    header('Location: dashboard.php');
    exit;
}

$error = '';
$success = '';
$email = '';

// Get flash message
$flash = getFlashMessage();
if ($flash) {
    if ($flash['type'] === 'success') {
        $success = $flash['text'];
    } else {
        $error = $flash['text'];
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitizeInput($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $csrf_token = $_POST['csrf_token'] ?? '';
    
    if (!verifyCSRFToken($csrf_token)) {
        $error = 'Invalid request. Please try again.';
    } elseif (empty($email) || empty($password)) {
        $error = 'Please fill in all fields.';
    } elseif (!isValidEmail($email)) {
        $error = 'Please enter a valid email address.';
    } else {
        if (!$pdo) {
            $error = 'Database connection unavailable. Please try again later.';
        } else {
            try {
                $stmt = $pdo->prepare("SELECT id, name, email, password FROM users WHERE email = ?");
                $stmt->execute([$email]);
                $user = $stmt->fetch();
                
                if ($user && verifyPassword($password, $user['password'])) {
                    loginUser($user['id'], $user['name'], $user['email']);
                    header('Location: dashboard.php');
                    exit;
                } else {
                    $error = 'Invalid email or password.';
                }
            } catch (PDOException $e) {
                $error = 'An error occurred. Please try again later.';
            }
        }
    }
}

include 'includes/header.php';
?>

<main class="auth-page">
    <div class="auth-container">
        <div class="auth-card">
            <h1>Welcome Back</h1>
            <p class="auth-subtitle">Sign in to access your dashboard</p>
            
            <?php if ($error): ?>
                <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>
            
            <form method="POST" class="auth-form">
                <input type="hidden" name="csrf_token" value="<?= generateCSRFToken() ?>">
                
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" required 
                           value="<?= htmlspecialchars($email ?? '') ?>"
                           placeholder="Enter your email">
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required
                           placeholder="Enter your password">
                </div>
                
                <button type="submit" class="cta-button auth-btn">Sign In</button>
            </form>
            
            <div class="auth-links">
                <p>Don't have an account? <a href="register.php">Create one</a></p>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
</body>
</html>
