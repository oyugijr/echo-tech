<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/blog.css">
    <title>Blog Post - EcoTech Solutions</title>
</head>
<body>
<?php 
require_once __DIR__ . '/bootstrap.php';

use EcoTech\Modules\Blog\BlogService;

$slug = $_GET['slug'] ?? '';

// Get blog post using the Blog service
$blogService = new BlogService($app->database());
$post = $blogService->getPostBySlug($slug);

include 'includes/header.php';
?>

<main class="blog-post-page">
    <article class="blog-post">
        <header class="post-header">
            <span class="post-category"><?= htmlspecialchars($post['category']) ?></span>
            <h1><?= htmlspecialchars($post['title']) ?></h1>
            <div class="post-meta">
                <span class="post-author">By <?= htmlspecialchars($post['author'] ?? 'EcoTech Team') ?></span>
                <span class="post-date"><?= date('F j, Y', strtotime($post['published_at'])) ?></span>
            </div>
        </header>
        
        <div class="post-image">
            <img src="images/blog/<?= htmlspecialchars($post['image']) ?>" alt="<?= htmlspecialchars($post['title']) ?>" onerror="this.src='images/blog/default.jpg'">
        </div>
        
        <div class="post-content">
            <?php 
            // Note: Blog content contains trusted HTML from admin/database
            // Do NOT use this pattern for user-generated content
            echo $post['content']; 
            ?>
        </div>
        
        <footer class="post-footer">
            <div class="share-buttons">
                <span>Share this article:</span>
                <a href="#" class="share-btn" onclick="shareOnTwitter()">Twitter</a>
                <a href="#" class="share-btn" onclick="shareOnLinkedIn()">LinkedIn</a>
                <a href="#" class="share-btn" onclick="shareOnFacebook()">Facebook</a>
            </div>
            
            <a href="blog.php" class="back-link">← Back to Blog</a>
        </footer>
    </article>
    
    <!-- Related Posts -->
    <section class="related-posts">
        <h2>Related Articles</h2>
        <div class="related-grid">
            <article class="related-card">
                <h3><a href="#">The Future of Renewable Energy in 2025</a></h3>
                <p>Explore the latest innovations and trends shaping the renewable energy landscape.</p>
            </article>
            <article class="related-card">
                <h3><a href="#">How Smart Buildings Are Revolutionizing Energy Efficiency</a></h3>
                <p>Learn how IoT and AI technologies are transforming buildings.</p>
            </article>
            <article class="related-card">
                <h3><a href="#">Water Conservation Strategies for Industrial Facilities</a></h3>
                <p>Practical approaches to reducing water consumption in industrial settings.</p>
            </article>
        </div>
    </section>
</main>

<script>
function shareOnTwitter() {
    window.open('https://twitter.com/intent/tweet?url=' + encodeURIComponent(window.location.href) + '&text=' + encodeURIComponent(document.title), '_blank');
}

function shareOnLinkedIn() {
    window.open('https://www.linkedin.com/sharing/share-offsite/?url=' + encodeURIComponent(window.location.href), '_blank');
}

function shareOnFacebook() {
    window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(window.location.href), '_blank');
}
</script>

<?php include 'includes/footer.php'; ?>
</body>
</html>
