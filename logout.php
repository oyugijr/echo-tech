<?php
/**
 * Logout Handler
 * 
 * Uses the modular Auth service for logout.
 */

require_once __DIR__ . '/bootstrap.php';

logoutUser();
redirectWithMessage('login.php', 'You have been signed out successfully.', 'success');
