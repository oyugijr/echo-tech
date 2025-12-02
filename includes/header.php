<?php
/**
 * Header Component
 * 
 * Uses the modular Auth service for authentication checks.
 */

// Include bootstrap if not already included (provides isLoggedIn function)
if (!function_exists('isLoggedIn')) {
    require_once __DIR__ . '/../bootstrap.php';
}
?>
<header class="main-header">
    <nav class="navbar">
        <div class="logo">
            <a href="home.php">EcoTech</a>
        </div>

        <ul class="nav-links">
            <li><a href="home.php">Home</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="services.php">Services</a></li>
            <li><a href="projects.php">Projects</a></li>
            <li><a href="blog.php">Blog</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="search.php" class="nav-search" aria-label="Search">🔍</a></li>
            <?php if (isLoggedIn()): ?>
                <li class="cta-link"><a href="dashboard.php" class="cta-button">Dashboard</a></li>
            <?php else: ?>
                <li class="cta-link"><a href="login.php" class="cta-button">Sign In</a></li>
            <?php endif; ?>
        </ul>

        <div class="hamburger">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </div>
    </nav>
</header>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const hamburger = document.querySelector('.hamburger');
    const navLinks = document.querySelector('.nav-links');

    hamburger.addEventListener('click', () => {
        navLinks.classList.toggle('active');
        hamburger.classList.toggle('active');
    });
});
</script>
