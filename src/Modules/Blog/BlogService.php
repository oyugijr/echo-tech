<?php
/**
 * Blog Service
 * 
 * Handles blog post retrieval and operations.
 */

namespace EcoTech\Modules\Blog;

use EcoTech\Core\Database\Connection;

class BlogService
{
    private ?Connection $db;

    /**
     * Sample blog posts for when database is unavailable
     */
    private array $samplePosts = [
        [
            'id' => 1,
            'title' => '10 Ways to Reduce Your Carbon Footprint at Home',
            'slug' => '10-ways-reduce-carbon-footprint',
            'excerpt' => 'Discover practical and easy-to-implement strategies to make your home more environmentally friendly and reduce your carbon emissions.',
            'image' => 'carbon-footprint.jpg',
            'category' => 'Sustainability Tips',
            'author' => 'Sarah Chen',
            'published_at' => null // Will be set dynamically
        ],
        [
            'id' => 2,
            'title' => 'The Future of Renewable Energy in 2025',
            'slug' => 'future-renewable-energy-2025',
            'excerpt' => 'Explore the latest innovations and trends shaping the renewable energy landscape and what they mean for businesses and consumers.',
            'image' => 'renewable-energy.jpg',
            'category' => 'Industry Insights',
            'published_at' => null
        ],
        [
            'id' => 3,
            'title' => 'How Smart Buildings Are Revolutionizing Energy Efficiency',
            'slug' => 'smart-buildings-energy-efficiency',
            'excerpt' => 'Learn how IoT and AI technologies are transforming buildings into intelligent energy-saving systems.',
            'image' => 'smart-building.jpg',
            'category' => 'Technology',
            'published_at' => null
        ],
        [
            'id' => 4,
            'title' => 'EcoTech Solutions Achieves Carbon Neutral Certification',
            'slug' => 'ecotech-carbon-neutral-certification',
            'excerpt' => 'We are proud to announce our achievement of carbon neutral certification, reflecting our commitment to sustainability.',
            'image' => 'certification.jpg',
            'category' => 'Company News',
            'published_at' => null
        ],
        [
            'id' => 5,
            'title' => 'Water Conservation Strategies for Industrial Facilities',
            'slug' => 'water-conservation-industrial',
            'excerpt' => 'Practical approaches to reducing water consumption and implementing sustainable water management in industrial settings.',
            'image' => 'water-conservation.jpg',
            'category' => 'Sustainability Tips',
            'published_at' => null
        ],
        [
            'id' => 6,
            'title' => 'Partnership Announcement: Green Energy Alliance',
            'slug' => 'partnership-green-energy-alliance',
            'excerpt' => 'EcoTech Solutions joins forces with leading organizations to accelerate the transition to clean energy.',
            'image' => 'partnership.jpg',
            'category' => 'Company News',
            'published_at' => null
        ]
    ];

    public function __construct(?Connection $db)
    {
        $this->db = $db;
        $this->initializeSampleDates();
    }

    /**
     * Initialize sample post dates dynamically
     */
    private function initializeSampleDates(): void
    {
        $dateOffsets = ['-2 days', '-5 days', '-1 week', '-2 weeks', '-3 weeks', '-1 month'];
        foreach ($this->samplePosts as $index => &$post) {
            $post['published_at'] = date('Y-m-d H:i:s', strtotime($dateOffsets[$index] ?? '-1 week'));
        }
    }

    /**
     * Get paginated blog posts
     * 
     * @return array{posts: array, total: int, totalPages: int}
     */
    public function getPosts(int $page = 1, int $perPage = 6): array
    {
        $offset = ($page - 1) * $perPage;
        $posts = [];
        $totalPosts = 0;

        $pdo = $this->db?->getPdo();

        if ($pdo) {
            try {
                // Get total count
                $stmt = $pdo->query("SELECT COUNT(*) FROM blog_posts WHERE status = 'published'");
                $totalPosts = (int) $stmt->fetchColumn();

                // Get posts for current page
                $stmt = $pdo->prepare("SELECT * FROM blog_posts WHERE status = 'published' ORDER BY published_at DESC LIMIT ? OFFSET ?");
                $stmt->execute([$perPage, $offset]);
                $posts = $stmt->fetchAll();
            } catch (\PDOException $e) {
                // Table might not exist - use sample data
            }
        }

        // Use sample data if no posts from database
        if (empty($posts)) {
            $posts = array_slice($this->samplePosts, $offset, $perPage);
            $totalPosts = count($this->samplePosts);
        }

        return [
            'posts' => $posts,
            'total' => $totalPosts,
            'totalPages' => max(1, (int) ceil($totalPosts / $perPage))
        ];
    }

    /**
     * Get a single blog post by slug
     */
    public function getPostBySlug(string $slug): ?array
    {
        $pdo = $this->db?->getPdo();

        if ($pdo && $slug) {
            try {
                $stmt = $pdo->prepare("SELECT * FROM blog_posts WHERE slug = ? AND status = 'published'");
                $stmt->execute([$slug]);
                $post = $stmt->fetch();
                if ($post) {
                    return $post;
                }
            } catch (\PDOException $e) {
                // Fall through to sample post
            }
        }

        // Return sample post
        return $this->getSamplePost($slug);
    }

    /**
     * Get sample post with full content
     */
    private function getSamplePost(string $slug = ''): array
    {
        return [
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

    /**
     * Get related posts (simple implementation)
     */
    public function getRelatedPosts(string $category, int $excludeId = 0, int $limit = 3): array
    {
        $pdo = $this->db?->getPdo();

        if ($pdo) {
            try {
                $stmt = $pdo->prepare("SELECT id, title, slug, excerpt FROM blog_posts WHERE category = ? AND id != ? AND status = 'published' ORDER BY published_at DESC LIMIT ?");
                $stmt->execute([$category, $excludeId, $limit]);
                $posts = $stmt->fetchAll();
                if (!empty($posts)) {
                    return $posts;
                }
            } catch (\PDOException $e) {
                // Fall through to sample posts
            }
        }

        // Return sample related posts
        return [
            ['title' => 'The Future of Renewable Energy in 2025', 'slug' => 'future-renewable-energy-2025', 'excerpt' => 'Explore the latest innovations and trends shaping the renewable energy landscape.'],
            ['title' => 'How Smart Buildings Are Revolutionizing Energy Efficiency', 'slug' => 'smart-buildings-energy-efficiency', 'excerpt' => 'Learn how IoT and AI technologies are transforming buildings.'],
            ['title' => 'Water Conservation Strategies for Industrial Facilities', 'slug' => 'water-conservation-industrial', 'excerpt' => 'Practical approaches to reducing water consumption in industrial settings.']
        ];
    }
}
