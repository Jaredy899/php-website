<?php
/**
 * Front Controller / Router
 */

require_once __DIR__ . '/config.php';
require_once INCLUDES_PATH . '/functions.php';

// Get the request path
$path = getCurrentPath();

// Route the request
if ($path === '/' || $path === '') {
    // Home page
    require PAGES_PATH . '/home.php';
} elseif (preg_match('#^/blog/([a-z0-9-]+)$#', $path, $matches)) {
    // Blog post
    $slug = $matches[1];
    require PAGES_PATH . '/blog.php';
} elseif (strpos($path, '/public/') === 0) {
    // Static files - let the server handle it
    return false;
} else {
    // 404
    http_response_code(404);
    require PAGES_PATH . '/home.php'; // Show home with 404 message or create a 404 page
}
