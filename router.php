<?php
/**
 * Router for PHP Built-in Server
 * Cho phép Pretty Permalinks hoạt động với php -S
 */

// Get the requested URI
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = urldecode($uri);

// Serve static files directly (CSS, JS, images, etc.)
$filePath = __DIR__ . $uri;
if ($uri !== '/' && file_exists($filePath) && is_file($filePath)) {
    return false; // Let PHP serve the file
}

// For all other requests, route to WordPress
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['SCRIPT_FILENAME'] = __DIR__ . '/index.php';

// Load WordPress
chdir(__DIR__);
require __DIR__ . '/index.php';

