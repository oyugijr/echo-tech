<?php
/**
 * Newsletter API Controller
 * 
 * Handles newsletter subscription API requests.
 */

namespace EcoTech\Modules\Newsletter\Controllers;

use EcoTech\Core\Http\Controller;
use EcoTech\Core\Http\Response;
use EcoTech\Modules\Auth\AuthService;
use EcoTech\Modules\Newsletter\NewsletterService;

class NewsletterController extends Controller
{
    private NewsletterService $newsletterService;

    public function __construct()
    {
        parent::__construct();
        $this->newsletterService = new NewsletterService($this->db());
    }

    /**
     * Handle subscription request (POST /api/subscribe.php)
     */
    public function subscribe(): void
    {
        // Only allow POST requests
        if (!$this->request->isPost()) {
            Response::methodNotAllowed();
        }

        // Get JSON input or form data
        $email = $this->request->json('email');
        if (!$email) {
            $email = $this->request->input('email');
        }

        $email = AuthService::sanitizeInput($email ?? '');

        // Validate email
        if (empty($email)) {
            $this->error('Email is required');
        }

        if (!AuthService::isValidEmail($email)) {
            $this->error('Please enter a valid email address');
        }

        // Process subscription
        $result = $this->newsletterService->subscribe($email);
        
        if ($result['success']) {
            $this->success([], $result['message']);
        } else {
            $this->error($result['message']);
        }
    }

    /**
     * Handle unsubscribe request
     */
    public function unsubscribe(): void
    {
        if (!$this->request->isPost()) {
            Response::methodNotAllowed();
        }

        $email = $this->request->json('email') ?? $this->request->input('email');
        $email = AuthService::sanitizeInput($email ?? '');

        if (empty($email) || !AuthService::isValidEmail($email)) {
            $this->error('Valid email is required');
        }

        $result = $this->newsletterService->unsubscribe($email);
        
        if ($result['success']) {
            $this->success([], $result['message']);
        } else {
            $this->error($result['message']);
        }
    }
}
