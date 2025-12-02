<?php
/**
 * Search API Handler
 * 
 * Delegates to the Search module controller.
 */

require_once __DIR__ . '/../bootstrap.php';

use EcoTech\Modules\Search\Controllers\SearchController;

header('Content-Type: application/json');

$controller = new SearchController();
$controller->search();
