<?php
/**
 * Blog Controller
 * 
 * Handles blog listing and single post display.
 */

namespace EcoTech\Modules\Blog\Controllers;

use EcoTech\Core\Http\Controller;
use EcoTech\Modules\Blog\BlogService;

class BlogController extends Controller
{
    private BlogService $blogService;

    public function __construct()
    {
        parent::__construct();
        $this->blogService = new BlogService($this->db());
    }

    /**
     * Display blog listing page
     */
    public function index(): void
    {
        $page = max(1, (int) $this->request->query('page', 1));
        $perPage = 6;

        $data = $this->blogService->getPosts($page, $perPage);

        // Make data available to the view
        $posts = $data['posts'];
        $totalPosts = $data['total'];
        $totalPages = $data['totalPages'];
        $pdo = $this->pdo();

        include $this->app->publicPath('blog.php');
    }

    /**
     * Display single blog post
     */
    public function show(): void
    {
        $slug = $this->request->query('slug', '');
        $post = $this->blogService->getPostBySlug($slug);
        $pdo = $this->pdo();

        include $this->app->publicPath('blog-post.php');
    }

    /**
     * Get blog service (for use in views if needed)
     */
    public function getService(): BlogService
    {
        return $this->blogService;
    }
}
