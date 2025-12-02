<?php
/**
 * Search API Controller
 * 
 * Handles search API requests.
 */

namespace EcoTech\Modules\Search\Controllers;

use EcoTech\Core\Http\Controller;
use EcoTech\Core\Http\Response;
use EcoTech\Modules\Auth\AuthService;
use EcoTech\Modules\Search\SearchService;

class SearchController extends Controller
{
    private SearchService $searchService;

    public function __construct()
    {
        parent::__construct();
        $this->searchService = new SearchService($this->db());
    }

    /**
     * Handle search API request (GET /api/search.php)
     */
    public function search(): void
    {
        // Only allow GET requests
        if (!$this->request->isGet()) {
            Response::methodNotAllowed();
        }

        $query = AuthService::sanitizeInput($this->request->query('q', ''));

        if (empty($query) || strlen($query) < 2) {
            $this->error('Search query must be at least 2 characters');
        }

        $results = $this->searchService->search($query);
        $this->json($results);
    }
}
