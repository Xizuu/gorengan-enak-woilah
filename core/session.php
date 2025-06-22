<?php

/**
 * Redirect to a given path relative to base URL.
 *
 * @param string $url Relative URL
 * @return void
 */
function redirect(string $url): void
{
    header("Location: " . $url);
    exit;
}

/**
 * Check if a user is currently logged in.
 *
 * @return bool True if user is logged in, false otherwise
 */
function is_logged_in(): bool
{
    return isset($_SESSION['username']) && !empty($_SESSION['username']);
}

/**
 * Enforce login requirement. Redirects to login page if not authenticated.
 *
 * @return void
 */
function require_login(): void
{
    if (!is_logged_in()) {
        redirect('/login');
    }
}

/**
 * Return current user data from session.
 *
 * @return array|null User data or null if not logged in
 */
function current_user(): ?string
{
    return $_SESSION['username'] ?? null;
}

/**
 * Escape string for safe output to HTML.
 *
 * @param string $string
 * @return string
 */
function e(string $string): string
{
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}