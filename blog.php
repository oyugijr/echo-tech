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
require_once 'includes/auth.php';
require_once 'includes/db_connect.php';

// Get blog posts with pagination
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$perPage = 6;
$offset = ($page - 1) * $perPage;

$posts = [];
$totalPosts = 0;

try {
    // Get total count
    $stmt = $pdo->query("SELECT COUNT(*) FROM blog_posts WHERE status = 'published'");
    $totalPosts = $stmt->fetchColumn();
    
    // Get posts for current page
    $stmt = $pdo->prepare("SELECT * FROM blog_posts WHERE status = 'published' ORDER BY published_at DESC LIMIT ? OFFSET ?");
    $stmt->execute([$perPage, $offset]);
    $posts = $stmt->fetchAll();
} catch (PDOException $e) {
    // Table might not exist - use sample data
    $posts = [
        [
            'id' => 1,
            'title' => '10 Ways to Reduce Your Carbon Footprint at Home',
            'slug' => '10-ways-reduce-carbon-footprint',
            'excerpt' => 'Discover practical and easy-to-implement strategies to make your home more environmentally friendly and reduce your carbon emissions.',
            'image' => 'carbon-footprint.jpg',
            'category' => 'Sustainability Tips',
            'published_at' => date('Y-m-d H:i:s', strtotime('-2 days'))
        ],
        [
            'id' => 2,
            'title' => 'The Future of Renewable Energy in 2025',
            'slug' => 'future-renewable-energy-2025',
            'excerpt' => 'Explore the latest innovations and trends shaping the renewable energy landscape and what they mean for businesses and consumers.',
            'image' => 'renewable-energy.jpg',
            'category' => 'Industry Insights',
            'published_at' => date('Y-m-d H:i:s', strtotime('-5 days'))
        ],
        [
            'id' => 3,
            'title' => 'How Smart Buildings Are Revolutionizing Energy Efficiency',
            'slug' => 'smart-buildings-energy-efficiency',
            'excerpt' => 'Learn how IoT and AI technologies are transforming buildings into intelligent energy-saving systems.',
            'image' => 'smart-building.jpg',
            'category' => 'Technology',
            'published_at' => date('Y-m-d H:i:s', strtotime('-1 week'))
        ],
        [
            'id' => 4,
            'title' => 'EcoTech Solutions Achieves Carbon Neutral Certification',
            'slug' => 'ecotech-carbon-neutral-certification',
            'excerpt' => 'We are proud to announce our achievement of carbon neutral certification, reflecting our commitment to sustainability.',
            'image' => 'certification.jpg',
            'category' => 'Company News',
            'published_at' => date('Y-m-d H:i:s', strtotime('-2 weeks'))
        ],
        [
            'id' => 5,
            'title' => 'Water Conservation Strategies for Industrial Facilities',
            'slug' => 'water-conservation-industrial',
            'excerpt' => 'Practical approaches to reducing water consumption and implementing sustainable water management in industrial settings.',
            'image' => 'water-conservation.jpg',
            'category' => 'Sustainability Tips',
            'published_at' => date('Y-m-d H:i:s', strtotime('-3 weeks'))
        ],
        [
            'id' => 6,
            'title' => 'Partnership Announcement: Green Energy Alliance',
            'slug' => 'partnership-green-energy-alliance',
            'excerpt' => 'EcoTech Solutions joins forces with leading organizations to accelerate the transition to clean energy.',
            'image' => 'partnership.jpg',
            'category' => 'Company News',
            'published_at' => date('Y-m-d H:i:s', strtotime('-1 month'))
        ]
    ];
}

$totalPages = max(1, ceil($totalPosts / $perPage)) ?: 1;

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
