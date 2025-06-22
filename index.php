<?php

/**
 * ---------------------------------------------------------------
 * ENTRY POINT (index.php)
 * ---------------------------------------------------------------
 * This file serves as the main front controller for the application.
 * It handles:
 * - Bootstrapping the application
 * - Parsing the requested URI
 * - Matching the request to defined routes
 * - Dispatching the corresponding route file
 *
 * If the route is not defined or the file does not exist,
 * a 404 response will be returned.
 */

// ---------------------------------------------------------------
// Load the Application Bootstrap
// ---------------------------------------------------------------
require_once __DIR__ . '/core/bootstrap.php';

// ---------------------------------------------------------------
// Define Application Routes
// ---------------------------------------------------------------
// Map of URL paths to PHP handler files
add_route("/", function() {
    include_once __DIR__ . BASE_APP . "/index.php";
}, 'get');

add_route("/dashboard", function() {
    include_once __DIR__ . BASE_APP . "/dashboard.php";
}, 'get');

add_route("/login", function() {
    echo "Login page";
}, ['get', 'post']);

add_route("/cart", function() {
    include_once __DIR__ . BASE_APP . "/cart.php";
}, 'get');
add_route("/cart/add", function() {
    include_once __DIR__ . BASE_APP . "/action/add_to_cart.php";
}, 'post');
add_route("/cart/remove", function() {
    include_once __DIR__ . BASE_APP . "/action/remove_from_cart.php";
}, 'get');
add_route("/cart/checkout", function() {
    include_once __DIR__ . BASE_APP . "/action/proses_bayar.php";
}, ['post', 'get']);

add_route("/produk", function() {
    include_once __DIR__ . BASE_APP . "/product.php";
}, 'get');
add_route("/produk/add", function() {
    include_once __DIR__ . BASE_APP . "/action/tambah_produk.php";
}, ['get', 'post']);
add_route("/produk/edit", function() {
    include_once __DIR__ . BASE_APP . "/action/edit_produk.php";
}, ['get', 'post']);
add_route("/produk/delete", function() {
    include_once __DIR__ . BASE_APP . "/action/hapus_produk.php";
}, ['get', 'post']);

add_route("/riwayat", function() {
    include_once __DIR__ . BASE_APP . "/history.php";
}, 'get');


// ---------------------------------------------------------------
// Route Dispatching
// ---------------------------------------------------------------
run_router("/");