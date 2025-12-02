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
require_once 'includes/auth.php';
require_once 'includes/db_connect.php';

$slug = $_GET['slug'] ?? '';
$post = null;

try {
    if ($slug && $pdo) {
        $stmt = $pdo->prepare("SELECT * FROM blog_posts WHERE slug = ? AND status = 'published'");
        $stmt->execute([$slug]);
        $post = $stmt->fetch();
    }
} catch (PDOException $e) {
    // Use sample post
}

// Sample post if not found in database
if (!$post) {
    $post = [
        'id' => 1,
        'title' => '10 Ways to Reduce Your Carbon Footprint at Home',
        'content' => '
            <p>Climate change is one of the most pressing challenges of our time, and while large-scale solutions are essential, individual actions can make a significant difference. Here are ten practical ways you can reduce your carbon footprint at home.</p>
            
            <h2>1. Switch to Renewable Energy</h2>
            <p>Consider installing solar panels or switching to a green energy provider. Many utility companies now offer renewable energy options that can significantly reduce your household\'s carbon emissions.</p>
            
            <h2>2. Improve Home Insulation</h2>
            <p>Proper insulation reduces the energy needed for heating and cooling. Check your attic, walls, and windows for areas where heat might be escaping.</p>
            
            <h2>3. Use Energy-Efficient Appliances</h2>
            <p>When it\'s time to replace appliances, look for ENERGY STAR certified products. These use significantly less energy than standard models.</p>
            
            <h2>4. Reduce Water Usage</h2>
            <p>Install low-flow showerheads and faucets, fix leaky pipes, and consider collecting rainwater for garden use.</p>
            
            <h2>5. Practice Smart Thermostat Management</h2>
            <p>A programmable thermostat can reduce energy consumption by automatically adjusting temperatures when you\'re asleep or away from home.</p>
            
            <h2>6. Choose Sustainable Transportation</h2>
            <p>When possible, walk, bike, or use public transportation. If you drive, consider carpooling or switching to an electric or hybrid vehicle.</p>
            
            <h2>7. Reduce, Reuse, Recycle</h2>
            <p>Follow the three R\'s: reduce consumption, reuse items when possible, and properly recycle materials that can be processed.</p>
            
            <h2>8. Eat More Plant-Based Meals</h2>
            <p>The meat industry is a significant contributor to greenhouse gas emissions. Even reducing meat consumption by a few meals per week can make a difference.</p>
            
            <h2>9. Support Sustainable Brands</h2>
            <p>Choose products from companies committed to sustainable practices and transparent supply chains.</p>
            
            <h2>10. Plant Trees and Gardens</h2>
            <p>Trees absorb carbon dioxide and provide habitat for wildlife. Even a small garden can contribute to local biodiversity and reduce your carbon footprint.</p>
            
            <h2>Conclusion</h2>
            <p>Every action counts in the fight against climate change. By implementing these strategies, you can reduce your environmental impact while often saving money on utilities and living a healthier lifestyle.</p>
        ',
        'image' => 'carbon-footprint.jpg',
        'category' => 'Sustainability Tips',
        'author' => 'Sarah Chen',
        'published_at' => date('Y-m-d H:i:s', strtotime('-2 days'))
    ];
}

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
