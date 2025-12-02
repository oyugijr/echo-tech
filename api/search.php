<?php
/**
 * Search API Handler
 */

header('Content-Type: application/json');

require_once __DIR__ . '/../includes/db_connect.php';
require_once __DIR__ . '/../includes/auth.php';

// Only allow GET requests
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$query = sanitizeInput($_GET['q'] ?? '');

if (empty($query) || strlen($query) < 2) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Search query must be at least 2 characters']);
    exit;
}

$results = [
    'services' => [],
    'projects' => [],
    'blog' => [],
    'pages' => []
];

try {
    if ($pdo) {
        // Search services
        $stmt = $pdo->prepare("SELECT id, title, description FROM services WHERE title LIKE ? OR description LIKE ? LIMIT 5");
        $searchTerm = "%$query%";
        $stmt->execute([$searchTerm, $searchTerm]);
        $results['services'] = $stmt->fetchAll();
        
        // Search projects
        $stmt = $pdo->prepare("SELECT id, title, description FROM projects WHERE title LIKE ? OR description LIKE ? LIMIT 5");
        $stmt->execute([$searchTerm, $searchTerm]);
        $results['projects'] = $stmt->fetchAll();
        
        // Search blog posts
        $stmt = $pdo->prepare("SELECT id, title, excerpt, slug FROM blog_posts WHERE (title LIKE ? OR excerpt LIKE ? OR content LIKE ?) AND status = 'published' LIMIT 5");
        $stmt->execute([$searchTerm, $searchTerm, $searchTerm]);
        $results['blog'] = $stmt->fetchAll();
    }
} catch (PDOException $e) {
    // Tables might not exist - provide sample results
}

// Static page search (always available)
$staticPages = [
    ['title' => 'Home', 'url' => 'home.php', 'description' => 'Welcome to EcoTech Solutions - Sustainable technology for a better future'],
    ['title' => 'About Us', 'url' => 'about.php', 'description' => 'Learn about our mission and team'],
    ['title' => 'Services', 'url' => 'services.php', 'description' => 'Our sustainable technology services'],
    ['title' => 'Projects', 'url' => 'projects.php', 'description' => 'Our portfolio of sustainable technology projects'],
    ['title' => 'Contact', 'url' => 'contact.php', 'description' => 'Get in touch with our team'],
    ['title' => 'Blog', 'url' => 'blog.php', 'description' => 'Latest news and sustainability tips'],
    ['title' => 'Privacy Policy', 'url' => 'privacy-policy.php', 'description' => 'Our privacy policy'],
    ['title' => 'Terms of Service', 'url' => 'terms.php', 'description' => 'Terms of service']
];

$queryLower = strtolower($query);
foreach ($staticPages as $page) {
    if (strpos(strtolower($page['title']), $queryLower) !== false || 
        strpos(strtolower($page['description']), $queryLower) !== false) {
        $results['pages'][] = $page;
    }
}

$totalResults = count($results['services']) + count($results['projects']) + count($results['blog']) + count($results['pages']);

echo json_encode([
    'success' => true,
    'query' => $query,
    'total' => $totalResults,
    'results' => $results
]);
?>
