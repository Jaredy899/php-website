<?php
/**
 * Helper Functions
 */

require_once VENDOR_PATH . '/Parsedown.php';

/**
 * Clean a slug - remove date prefixes and normalize
 */
function cleanSlug(string $originalSlug): string {
    $parts = explode('/', $originalSlug);
    $lastSegment = end($parts) ?: $originalSlug;
    
    // Remove .md extension if present
    $lastSegment = preg_replace('/\.md$/', '', $lastSegment);
    
    // Remove leading date (YYYY-MM-DD-) or numeric prefixes (e.g., 12-)
    $withoutPrefixes = preg_replace('/^\d{4}-\d{2}-\d{2}-/', '', $lastSegment);
    $withoutPrefixes = preg_replace('/^\d+-/', '', $withoutPrefixes);
    
    // Basic slugify: lowercase, replace non-alphanumerics with '-', collapse, and trim '-'
    $simplified = strtolower($withoutPrefixes);
    $simplified = preg_replace('/[^a-z0-9-]+/', '-', $simplified);
    $simplified = preg_replace('/--+/', '-', $simplified);
    $simplified = trim($simplified, '-');
    
    return $simplified;
}

/**
 * Parse frontmatter from markdown content
 */
function parseFrontmatter(string $content): array {
    $result = [
        'frontmatter' => [],
        'content' => $content
    ];
    
    // Check for frontmatter delimiter
    if (preg_match('/^---\s*\n(.*?)\n---\s*\n(.*)$/s', $content, $matches)) {
        $yaml = $matches[1];
        $result['content'] = $matches[2];
        
        // Simple YAML parsing for our needs
        $lines = explode("\n", $yaml);
        foreach ($lines as $line) {
            if (preg_match('/^(\w+):\s*(.*)$/', $line, $m)) {
                $key = $m[1];
                $value = trim($m[2]);
                
                // Remove quotes if present
                $value = trim($value, '"\'');
                
                // Parse boolean
                if ($value === 'true') $value = true;
                elseif ($value === 'false') $value = false;
                
                $result['frontmatter'][$key] = $value;
            }
        }
    }
    
    return $result;
}

/**
 * Get all blog posts
 */
function getAllPosts(): array {
    $posts = [];
    $contentDir = CONTENT_PATH . '/blog';
    
    // Recursively find all .md files
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($contentDir, RecursiveDirectoryIterator::SKIP_DOTS)
    );
    
    foreach ($iterator as $file) {
        if ($file->getExtension() !== 'md') continue;
        
        $content = file_get_contents($file->getPathname());
        $parsed = parseFrontmatter($content);
        
        // Skip drafts
        if (!empty($parsed['frontmatter']['draft']) && $parsed['frontmatter']['draft'] === true) {
            continue;
        }
        
        // Get relative path for slug
        $relativePath = str_replace($contentDir . '/', '', $file->getPathname());
        $slug = cleanSlug($relativePath);
        
        $posts[] = [
            'slug' => $slug,
            'originalSlug' => $relativePath,
            'filepath' => $file->getPathname(),
            'title' => $parsed['frontmatter']['title'] ?? 'Untitled',
            'description' => $parsed['frontmatter']['description'] ?? '',
            'pubDate' => $parsed['frontmatter']['pubDate'] ?? date('Y-m-d'),
            'draft' => $parsed['frontmatter']['draft'] ?? false,
            'category' => $parsed['frontmatter']['category'] ?? '',
            'tags' => $parsed['frontmatter']['tags'] ?? [],
        ];
    }
    
    // Sort by date (newest first)
    usort($posts, function($a, $b) {
        return strtotime($b['pubDate']) - strtotime($a['pubDate']);
    });
    
    return $posts;
}

/**
 * Get a single post by slug
 */
function getPostBySlug(string $slug): ?array {
    $posts = getAllPosts();
    
    foreach ($posts as $post) {
        if ($post['slug'] === $slug) {
            // Load full content
            $content = file_get_contents($post['filepath']);
            $parsed = parseFrontmatter($content);
            
            // Parse markdown
            $parsedown = new Parsedown();
            $parsedown->setSafeMode(false);
            $post['htmlContent'] = $parsedown->text($parsed['content']);
            
            return $post;
        }
    }
    
    return null;
}

/**
 * Format date for display
 */
function formatDate(string $date): string {
    $timestamp = strtotime($date);
    return gmdate('F j, Y', $timestamp);
}

/**
 * Get current URL path
 */
function getCurrentPath(): string {
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    return rtrim($path, '/') ?: '/';
}
