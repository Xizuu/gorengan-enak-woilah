<?php
/**
 * ---------------------------------------------------------------
 * BOOTSTRAP FILE
 * ---------------------------------------------------------------
 * This file is responsible for initializing the core components
 * of the application including:
 * - Session management
 * - Application configuration
 * - Database connection
 * - Default timezone
 * - Global helper functions
 *
 * This file should be included at the beginning of all entry points
 * (e.g., index.php, route files) to ensure proper application setup.
 */

// ---------------------------------------------------------------
// Start Session
// ---------------------------------------------------------------
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ---------------------------------------------------------------
// Load Configuration
// ---------------------------------------------------------------
// Load global constants like BASE_URL, DB_HOST, etc.
require_once __DIR__ . '/config.php';

// ---------------------------------------------------------------
// Load Database Connection
// ---------------------------------------------------------------
// Establish a global PDO connection to the database
require_once __DIR__ . '/database.php';

// -----------------------------------------------------------------------------
// Application Bootstrap: Router Initialization
// -----------------------------------------------------------------------------
// This file is responsible for initializing the application router.
// It loads the routing engine and prepares route registration.
// All route definitions should be registered after this inclusion.
//
// Note: Ensure this file is required at the application's entry point 
//       (e.g., index.php) before defining any routes.
// -----------------------------------------------------------------------------

require_once __DIR__ . '/router.php';

// ---------------------------------------------------------------
// Set Default Timezone
// ---------------------------------------------------------------
// Ensures consistent date/time handling across the application
date_default_timezone_set('Asia/Jakarta');