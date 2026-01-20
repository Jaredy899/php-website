<?php
/**
 * Blog Post Page
 * Expects $slug to be set from router
 */

require_once INCLUDES_PATH . '/jc-logo.php';

// Get the post
$post = getPostBySlug($slug);

if (!$post) {
    http_response_code(404);
    $pageTitle = 'Post Not Found - ' . SITE_TITLE;
    $pageDescription = 'The requested blog post was not found.';
    $content = '<div class="not-found"><h1>Post Not Found</h1><p>Sorry, the blog post you\'re looking for doesn\'t exist.</p><a href="/">Go Home</a></div>';
    $isBlogPage = true;
    $isHomePage = false;
    include INCLUDES_PATH . '/layout.php';
    exit;
}

$pageTitle = $post['title'] . ' - ' . SITE_TITLE;
$pageDescription = $post['description'];
$isHomePage = false;
$isBlogPage = true;

ob_start();
?>
<header class="page-header" id="page-header">
    <button id="header-sidebar-toggle" aria-label="Toggle sidebar">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
            <line x1="8" y1="6" x2="8" y2="18"></line>
        </svg>
    </button>
    <div class="logo-container blog-logo" style="view-transition-name: jc-logo;">
        <a href="/" class="logo-link" aria-label="Return to home page">
            <?php renderLogo(); ?>
        </a>
    </div>
    <button id="header-theme-toggle" aria-label="Toggle dark mode">
        <svg class="header-sun-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="5"></circle>
            <line x1="12" y1="1" x2="12" y2="3"></line>
            <line x1="12" y1="21" x2="12" y2="23"></line>
            <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
            <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
            <line x1="1" y1="12" x2="3" y2="12"></line>
            <line x1="21" y1="12" x2="23" y2="12"></line>
            <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
            <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
        </svg>
        <svg class="header-moon-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
        </svg>
    </button>
</header>
<main class="container mx-auto px-4 py-8 blog-main">
    <article class="prose dark:prose-invert mx-auto fade-in blog-post">
        <time class="text-sm text-gray-500 dark:text-gray-400 blog-date">
            <?= formatDate($post['pubDate']) ?>
        </time>
        <div class="mt-8 blog-content">
            <?= $post['htmlContent'] ?>
        </div>
    </article>
</main>
<?php
$content = ob_get_clean();

include INCLUDES_PATH . '/layout.php';
