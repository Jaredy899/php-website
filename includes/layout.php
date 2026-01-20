<?php
/**
 * Main Layout Template
 * 
 * Variables expected:
 * - $pageTitle: Page title
 * - $pageDescription: Page description
 * - $content: Main content (HTML)
 * - $isHomePage: Boolean, true if home page
 * - $isBlogPage: Boolean, true if blog post page
 */

$posts = getAllPosts();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Jared Cervantes - Personal Website">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="/public/favicon.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@400;500;600;700&family=Fira+Code:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/styles.css">
    <!-- highlight.js for code syntax highlighting -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github-dark.min.css">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <meta name="title" content="<?= htmlspecialchars($pageTitle) ?>">
    <meta name="description" content="<?= htmlspecialchars($pageDescription) ?>">
</head>
<body>
    <?php if (empty($isBlogPage)): ?>
    <button id="sidebar-toggle" aria-label="Toggle sidebar">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
            <line x1="8" y1="6" x2="8" y2="18"></line>
        </svg>
    </button>
    <?php endif; ?>
    
    <?php include INCLUDES_PATH . '/sidebar.php'; ?>
    <?php include INCLUDES_PATH . '/theme-toggle.php'; ?>
    
    <main id="main-content">
        <?= $content ?>
    </main>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
    <script src="/public/js/main.js"></script>
</body>
</html>
