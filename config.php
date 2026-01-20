<?php
/**
 * Site Configuration
 */

define('SITE_TITLE', 'Jared Cervantes');
define('SITE_DESCRIPTION', 'Personal website of Jared Cervantes');
define('SITE_URL', ''); // Leave empty for relative URLs

// Paths
define('ROOT_PATH', __DIR__);
define('CONTENT_PATH', ROOT_PATH . '/content');
define('INCLUDES_PATH', ROOT_PATH . '/includes');
define('PAGES_PATH', ROOT_PATH . '/pages');
define('VENDOR_PATH', ROOT_PATH . '/vendor');

// Error reporting (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Timezone
date_default_timezone_set('UTC');
