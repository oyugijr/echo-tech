<?php
/**
 * Pages Controller
 * 
 * Handles static pages like home, about, services, projects, etc.
 */

namespace EcoTech\Modules\Pages\Controllers;

use EcoTech\Core\Http\Controller;
use EcoTech\Modules\Pages\PagesService;

class PagesController extends Controller
{
    private PagesService $pagesService;

    public function __construct()
    {
        parent::__construct();
        $this->pagesService = new PagesService($this->db());
    }

    /**
     * Display home page
     */
    public function home(): void
    {
        $projects = $this->pagesService->getFeaturedProjects(3);
        $pdo = $this->pdo();

        include $this->app->publicPath('home.php');
    }

    /**
     * Display about page
     */
    public function about(): void
    {
        include $this->app->publicPath('about.php');
    }

    /**
     * Display services page
     */
    public function services(): void
    {
        $services = $this->pagesService->getServices();
        $pdo = $this->pdo();

        include $this->app->publicPath('services.php');
    }

    /**
     * Display projects page
     */
    public function projects(): void
    {
        $projects = $this->pagesService->getProjects();
        $pdo = $this->pdo();

        include $this->app->publicPath('projects.php');
    }

    /**
     * Display contact page
     */
    public function contact(): void
    {
        include $this->app->publicPath('contact.php');
    }

    /**
     * Display privacy policy page
     */
    public function privacyPolicy(): void
    {
        include $this->app->publicPath('privacy-policy.php');
    }

    /**
     * Display terms of service page
     */
    public function terms(): void
    {
        include $this->app->publicPath('terms.php');
    }

    /**
     * Display search page
     */
    public function search(): void
    {
        $query = htmlspecialchars($this->request->query('q', ''));
        include $this->app->publicPath('search.php');
    }

    /**
     * Get pages service (for use in views)
     */
    public function getService(): PagesService
    {
        return $this->pagesService;
    }
}
