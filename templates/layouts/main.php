<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/styles.css">
    <?php if (isset($pageClass) && $pageClass === 'home-page'): ?>
    <link rel="stylesheet" href="/assets/css/home.css">
    <?php endif; ?>
    <title><?= htmlspecialchars($title ?? 'EcoTech Solutions') ?></title>
</head>
<body class="<?= $pageClass ?? '' ?>">
    
    <!-- Header -->
    <header class="site-header">
        <div class="container">
            <div class="header-content">
                <a href="/" class="logo">
                    <span class="logo-text">EcoTech Solutions</span>
                </a>
                
                <nav class="main-nav">
                    <ul>
                        <li><a href="/home">Home</a></li>
                        <li><a href="/about">About</a></li>
                        <li><a href="/services">Services</a></li>
                        <li><a href="/projects">Projects</a></li>
                        <li><a href="/blog">Blog</a></li>
                        <li><a href="/contact">Contact</a></li>
                        
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <li><a href="/dashboard">Dashboard</a></li>
                            <li><a href="/logout">Logout</a></li>
                        <?php else: ?>
                            <li><a href="/login">Login</a></li>
                            <li><a href="/register">Register</a></li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </div>
    </header>
    
    <!-- Main Content -->
    <main>
        <?= $content ?>
    </main>
    
    <!-- Footer -->
    <footer class="site-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>EcoTech Solutions</h3>
                    <p>Sustainable Technology for a Better Future</p>
                </div>
                
                <div class="footer-section">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="/about">About Us</a></li>
                        <li><a href="/services">Services</a></li>
                        <li><a href="/contact">Contact</a></li>
                        <li><a href="/privacy-policy">Privacy Policy</a></li>
                        <li><a href="/terms">Terms & Conditions</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h4>Newsletter</h4>
                    <form action="/api/subscribe" method="POST" class="newsletter-form">
                        <input type="email" name="email" placeholder="Your email" required>
                        <button type="submit">Subscribe</button>
                    </form>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; <?= date('Y') ?> EcoTech Solutions. All rights reserved.</p>
            </div>
        </div>
    </footer>
    
    <!-- Chat Widget -->
    <div id="chat-widget">
        <button id="chat-toggle" class="chat-toggle">💬</button>
        <div id="chat-window" class="chat-window" style="display: none;">
            <div class="chat-header">
                <h4>Chat with us</h4>
                <button id="chat-close">×</button>
            </div>
            <div class="chat-body">
                <p>How can we help you today?</p>
            </div>
        </div>
    </div>
    
    <script src="/assets/js/main.js"></script>
</body>
</html>
