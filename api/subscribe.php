<?php
/**
 * Newsletter Subscription API Handler
 * 
 * Delegates to the Newsletter module controller.
 */

require_once __DIR__ . '/../bootstrap.php';

use EcoTech\Modules\Newsletter\Controllers\NewsletterController;

header('Content-Type: application/json');

$controller = new NewsletterController();
$controller->subscribe();
