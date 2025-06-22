<?php
/**
 * ===============================================================
 * DATABASE CONNECTION FILE
 * ===============================================================
 * This file initializes a secure connection to the MySQL database
 * using the `mysqli` extension. It uses constants defined in
 * `config.php` for connection credentials and schema selection.
 *
 * KEY FEATURES:
 * - Validates required configuration constants
 * - Handles connection errors gracefully
 * - Logs errors without exposing sensitive details to users
 * - Sets UTF-8 encoding for reliable multi-language support
 *
 * NOTE:
 * This file should be required once during the bootstrap process.
 * Ensure `config.php` is loaded before this file.
 */

// ---------------------------------------------------------------
// Validate Database Configuration
// ---------------------------------------------------------------
// Ensure all required constants are defined before attempting connection
if (
    !defined('DB_HOST') ||
    !defined('DB_USER') ||
    !defined('DB_PASS') ||
    !defined('DB_SCHEMA')
) {
    die('Missing database configuration. Please check config.php.');
}

// ---------------------------------------------------------------
// Establish Database Connection
// ---------------------------------------------------------------
// Using mysqli_connect() with previously defined constants
$koneksi = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_SCHEMA);

// ---------------------------------------------------------------
// Check for Connection Errors
// ---------------------------------------------------------------
// If connection fails, log the error and display a safe message
if (!$koneksi) {
    // Log the detailed error for developer debugging
    error_log('MySQL Connection Error: ' . mysqli_connect_error());

    // Do not expose sensitive information to end users
    die('Unable to connect to the database. Please contact the administrator.');
}

// ---------------------------------------------------------------
// Set Charset to UTF-8 (utf8mb4)
// ---------------------------------------------------------------
// Ensures proper encoding support for special characters and emojis
mysqli_set_charset($koneksi, 'utf8mb4');