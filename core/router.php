<?php

/**
 * ---------------------------------------------------------------
 * Simple PHP Native Router
 * Inspired by Laravel Routing Syntax
 * ---------------------------------------------------------------
 * This router supports:
 *  - Named route registration
 *  - Multiple HTTP methods
 *  - Custom handlers for path not found & method not allowed
 *  - Clean URL matching with optional basepath
 * ---------------------------------------------------------------
 */

$routes = [];
$pathNotFound = null;
$methodNotAllowed = null;

/**
 * Register a new route
 *
 * @param string $expression Route URI pattern (regex-compatible)
 * @param callable $function Function to call when matched
 * @param string|array $method HTTP method(s), default is 'get'
 */
function add_route($expression, $function, $method = 'get') {
    global $routes;
    $routes[] = [
        'expression' => $expression,
        'function' => $function,
        'method' => $method
    ];
}

/**
 * Get all registered routes
 *
 * @return array
 */
function get_all_routes() {
    global $routes;
    return $routes;
}

/**
 * Register a handler for "path not found" case
 *
 * @param callable $function
 */
function on_path_not_found($function) {
    global $pathNotFound;
    $pathNotFound = $function;
}

/**
 * Register a handler for "method not allowed" case
 *
 * @param callable $function
 */
function on_method_not_allowed($function) {
    global $methodNotAllowed;
    $methodNotAllowed = $function;
}

/**
 * Run the router
 *
 * @param string $basepath Base path of the app (e.g., '/myapp')
 * @param bool $case_matters Whether route matching is case-sensitive
 * @param bool $trailing_slash_matters Whether trailing slashes matter
 * @param bool $multimatch Allow multiple route matches (default: false)
 */
function run_router($basepath = '', $case_matters = false, $trailing_slash_matters = false, $multimatch = false) {
    global $routes, $pathNotFound, $methodNotAllowed;

    $basepath = rtrim($basepath, '/');

    $parsed_url = parse_url($_SERVER['REQUEST_URI']);
    $path = '/';

    // Determine the request path
    if (isset($parsed_url['path'])) {
        $path = $trailing_slash_matters
            ? $parsed_url['path']
            : (($basepath . '/' !== $parsed_url['path']) ? rtrim($parsed_url['path'], '/') : $parsed_url['path']);
    }

    $path = urldecode($path);
    $method = $_SERVER['REQUEST_METHOD'];
    $path_match_found = false;
    $route_match_found = false;

    // Loop through registered routes
    foreach ($routes as $route) {
        $expression = $route['expression'];

        // Prepend basepath if necessary
        if ($basepath !== '' && $basepath !== '/') {
            $expression = '(' . $basepath . ')' . $expression;
        }

        // Add regex delimiters and anchors
        $expression = '^' . $expression . '$';

        // Match route pattern
        if (preg_match('#' . $expression . '#' . ($case_matters ? '' : 'i') . 'u', $path, $matches)) {
            $path_match_found = true;

            foreach ((array)$route['method'] as $allowedMethod) {
                if (strtolower($method) === strtolower($allowedMethod)) {
                    array_shift($matches); // Full match
                    if ($basepath !== '' && $basepath !== '/') {
                        array_shift($matches); // Remove basepath match
                    }

                    // Call the route's handler
                    $result = call_user_func_array($route['function'], $matches);
                    if ($result) {
                        echo $result;
                    }

                    $route_match_found = true;
                    break;
                }
            }
        }

        // If route matched and multimatch is false, stop
        if ($route_match_found && !$multimatch) {
            break;
        }
    }

    // Handle 404 or 405
    if (!$route_match_found) {
        if ($path_match_found && $methodNotAllowed) {
            $result = call_user_func_array($methodNotAllowed, [$path, $method]);
            if ($result) echo $result;
        } elseif (!$path_match_found && $pathNotFound) {
            $result = call_user_func_array($pathNotFound, [$path]);
            if ($result) echo $result;
        }
    }
}
