<?php
/**
 * Database Connection
 * 
 * This file provides backward compatibility by delegating to the Core Database module.
 * For new code, use the Application instance and its database() method.
 */

require_once __DIR__ . '/../bootstrap.php';

// The $pdo and $db_error variables are now set in bootstrap.php
// This file is kept for backward compatibility with existing includes