<?php
/**
 * Search Service
 * 
 * Handles search operations across different content types.
 */

namespace EcoTech\Modules\Search;

use EcoTech\Core\Database\Connection;

class SearchService
{
    private ?Connection $db;

    /**
     * Static pages that can be searched
     */
    private array $staticPages = [
        ['title' => 'Home', 'url' => 'home.php', 'description' => 'Welcome to EcoTech Solutions - Sustainable technology for a better future'],
        ['title' => 'About Us', 'url' => 'about.php', 'description' => 'Learn about our mission and team'],
        ['title' => 'Services', 'url' => 'services.php', 'description' => 'Our sustainable technology services'],
        ['title' => 'Projects', 'url' => 'projects.php', 'description' => 'Our portfolio of sustainable technology projects'],
        ['title' => 'Contact', 'url' => 'contact.php', 'description' => 'Get in touch with our team'],
        ['title' => 'Blog', 'url' => 'blog.php', 'description' => 'Latest news and sustainability tips'],
        ['title' => 'Privacy Policy', 'url' => 'privacy-policy.php', 'description' => 'Our privacy policy'],
        ['title' => 'Terms of Service', 'url' => 'terms.php', 'description' => 'Terms of service']
    ];

    public function __construct(?Connection $db)
    {
        $this->db = $db;
    }

    /**
     * Perform a search across all content types
     * 
     * @return array{success: bool, query: string, total: int, results: array}
     */
    public function search(string $query): array
    {
        $results = [
            'services' => [],
            'projects' => [],
            'blog' => [],
            'pages' => []
        ];

        $pdo = $this->db?->getPdo();

        try {
            if ($pdo) {
                // Search services
                $results['services'] = $this->searchServices($pdo, $query);
                
                // Search projects
                $results['projects'] = $this->searchProjects($pdo, $query);
                
                // Search blog posts
                $results['blog'] = $this->searchBlog($pdo, $query);
            }
        } catch (\PDOException $e) {
            // Tables might not exist - continue with static results
        }

        // Static page search (always available)
        $results['pages'] = $this->searchStaticPages($query);

        $totalResults = count($results['services']) + count($results['projects']) + 
                       count($results['blog']) + count($results['pages']);

        return [
            'success' => true,
            'query' => $query,
            'total' => $totalResults,
            'results' => $results
        ];
    }

    /**
     * Search services table
     */
    private function searchServices(\PDO $pdo, string $query): array
    {
        $stmt = $pdo->prepare("SELECT id, title, description FROM services WHERE title LIKE ? OR description LIKE ? LIMIT 5");
        $searchTerm = "%{$query}%";
        $stmt->execute([$searchTerm, $searchTerm]);
        return $stmt->fetchAll();
    }

    /**
     * Search projects table
     */
    private function searchProjects(\PDO $pdo, string $query): array
    {
        $stmt = $pdo->prepare("SELECT id, title, description FROM projects WHERE title LIKE ? OR description LIKE ? LIMIT 5");
        $searchTerm = "%{$query}%";
        $stmt->execute([$searchTerm, $searchTerm]);
        return $stmt->fetchAll();
    }

    /**
     * Search blog posts table
     */
    private function searchBlog(\PDO $pdo, string $query): array
    {
        $stmt = $pdo->prepare("SELECT id, title, excerpt, slug FROM blog_posts WHERE (title LIKE ? OR excerpt LIKE ? OR content LIKE ?) AND status = 'published' LIMIT 5");
        $searchTerm = "%{$query}%";
        $stmt->execute([$searchTerm, $searchTerm, $searchTerm]);
        return $stmt->fetchAll();
    }

    /**
     * Search static pages
     */
    private function searchStaticPages(string $query): array
    {
        $queryLower = strtolower($query);
        $results = [];

        foreach ($this->staticPages as $page) {
            if (stripos($page['title'], $queryLower) !== false ||
                stripos($page['description'], $queryLower) !== false) {
                $results[] = $page;
            }
        }

        return $results;
    }
}
