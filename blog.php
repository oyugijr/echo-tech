<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/blog.css">
    <title>Blog - EcoTech Solutions</title>
</head>
<body>
<?php 
require_once __DIR__ . '/bootstrap.php';

use EcoTech\Modules\Blog\BlogService;

// Get blog posts with pagination using the Blog service
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$perPage = 6;

$blogService = new BlogService($app->database());
$data = $blogService->getPosts($page, $perPage);

$posts = $data['posts'];
$totalPosts = $data['total'];
$totalPages = $data['totalPages'];

include 'includes/header.php';
?>

<main class="blog-page">
    <section class="blog-header">
        <h1>Blog & News</h1>
        <p class="header-subtext">Stay informed about the latest sustainability trends, industry insights, and EcoTech updates</p>
    </section>
    
    <div class="blog-container">
        <!-- Category Filter -->
        <div class="blog-filters">
            <button class="filter-btn active" data-category="all">All Posts</button>
            <button class="filter-btn" data-category="sustainability">Sustainability Tips</button>
            <button class="filter-btn" data-category="technology">Technology</button>
            <button class="filter-btn" data-category="news">Company News</button>
            <button class="filter-btn" data-category="insights">Industry Insights</button>
        </div>
        
        <!-- Blog Posts Grid -->
        <div class="blog-grid">
            <?php foreach ($posts as $post): ?>
            <article class="blog-card" data-category="<?= strtolower(str_replace(' ', '-', $post['category'])) ?>">
                <div class="blog-image">
                    <img src="images/blog/<?= htmlspecialchars($post['image']) ?>" alt="<?= htmlspecialchars($post['title']) ?>" onerror="this.src='images/blog/default.jpg'">
                    <span class="blog-category"><?= htmlspecialchars($post['category']) ?></span>
                </div>
                <div class="blog-content">
                    <time class="blog-date"><?= date('F j, Y', strtotime($post['published_at'])) ?></time>
                    <h2><a href="blog-post.php?slug=<?= htmlspecialchars($post['slug'] ?? $post['id']) ?>"><?= htmlspecialchars($post['title']) ?></a></h2>
                    <p><?= htmlspecialchars($post['excerpt']) ?></p>
                    <a href="blog-post.php?slug=<?= htmlspecialchars($post['slug'] ?? $post['id']) ?>" class="read-more">Read More →</a>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
        
        <!-- Pagination -->
        <?php if ($totalPages > 1): ?>
        <nav class="pagination">
            <?php if ($page > 1): ?>
                <a href="?page=<?= $page - 1 ?>" class="page-btn">← Previous</a>
            <?php endif; ?>
            
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?= $i ?>" class="page-btn <?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
            <?php endfor; ?>
            
            <?php if ($page < $totalPages): ?>
                <a href="?page=<?= $page + 1 ?>" class="page-btn">Next →</a>
            <?php endif; ?>
        </nav>
        <?php endif; ?>
    </div>
    
    <!-- Newsletter Section -->
    <section class="blog-newsletter">
        <div class="newsletter-content">
            <h2>Subscribe to Our Newsletter</h2>
            <p>Get the latest sustainability tips and company updates delivered to your inbox.</p>
            <form class="newsletter-form" id="blogNewsletterForm">
                <input type="email" name="email" placeholder="Enter your email address" required>
                <button type="submit" class="cta-button">Subscribe</button>
            </form>
            <p class="newsletter-note">We respect your privacy. Unsubscribe at any time.</p>
        </div>
    </section>
</main>

<script>
// Category filter functionality
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        
        const category = this.dataset.category;
        document.querySelectorAll('.blog-card').forEach(card => {
            if (category === 'all' || card.dataset.category.includes(category)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });
});
</script>

<?php include 'includes/footer.php'; ?>
</body>
</html>
