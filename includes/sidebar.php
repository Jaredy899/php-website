<?php
/**
 * Sidebar Component
 * Expects $posts array to be available
 */
?>
<div id="sidebar-overlay" class="sidebar-overlay" aria-hidden="true">
    <aside id="sidebar" class="blog-sidebar" aria-label="Blog navigation">
        <div class="sidebar-header">
            <h2>Blog Posts</h2>
            <button class="close-btn" id="sidebar-close-btn" aria-label="Close sidebar">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>

        <div class="sidebar-content">
            <?php if (empty($posts)): ?>
                <div class="no-posts">No blog posts yet</div>
            <?php else: ?>
                <ul class="posts-list">
                    <?php foreach ($posts as $post): ?>
                        <li>
                            <a href="/blog/<?= htmlspecialchars($post['slug']) ?>" 
                               class="post-link"
                               aria-label="<?= htmlspecialchars($post['title']) ?> - Published on <?= formatDate($post['pubDate']) ?>">
                                <div class="post-title"><?= htmlspecialchars($post['title']) ?></div>
                                <div class="post-date"><?= formatDate($post['pubDate']) ?></div>
                                <?php if (!empty($post['description'])): ?>
                                    <div class="post-description"><?= htmlspecialchars($post['description']) ?></div>
                                <?php endif; ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </aside>
</div>
