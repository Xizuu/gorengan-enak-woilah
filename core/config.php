<?php
/**
 * ---------------------------------------------------------------
 * APPLICATION CONFIGURATION
 * ---------------------------------------------------------------
 * This file contains global constants used throughout the application.
 * It includes:
 * - Base URL configuration
 * - Project root folder name
 * - Database connection credentials
 * - Session settings
 *
 * These constants are loaded during the bootstrap phase and
 * should be kept secure and consistent.
 */

// ---------------------------------------------------------------
// Base URL of the Application
// ---------------------------------------------------------------
// Used to generate full URLs dynamically (e.g., in base_url() helper)
define('BASE_URL', 'http://localhost:8000');

// ---------------------------------------------------------------
// Project Root Directory
// ---------------------------------------------------------------
// (Optional) Used if application files are inside a subdirectory
// define('PROJECT_ROOT', "/app");
define('BASE_APP', '/app');

// ---------------------------------------------------------------
// Assets Directory
// ---------------------------------------------------------------
// (Optional) Define the public path to your static assets (CSS, JS, images, etc).
// Update this if your assets are located in a specific directory like "/public/assets".
define('ASSETS', '/public/assets');

// ---------------------------------------------------------------
// Database Connection Settings
// ---------------------------------------------------------------
// These constants are used by the PDO connector in core/db.php
define('DB_HOST', 'localhost');       // Database server host
define('DB_USER', 'root');            // MySQL username
define('DB_PASS', '');                // MySQL password
define('DB_SCHEMA', 'gorengan');     // Database name (schema)

// ---------------------------------------------------------------
// Session Configuration
// ---------------------------------------------------------------
// Defines how long (in seconds) a session remains active
define('SESSION_TIMEOUT', 3600); // 1 hour