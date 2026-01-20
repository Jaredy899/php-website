/**
 * Main JavaScript for PHP Website
 */

// ===========================================
// Theme Management
// ===========================================
const setupTheme = () => {
    const savedTheme = localStorage.getItem('theme');
    const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
    
    // Determine theme: saved > system preference > default to light
    const theme = savedTheme || (prefersDark ? 'dark' : 'light');
    
    // Apply theme
    const isDark = theme === 'dark';
    document.documentElement.classList.toggle('dark', isDark);
    
    // Update icons
    updateThemeIcons(isDark);
    
    // Save theme if not already saved
    if (!savedTheme) {
        localStorage.setItem('theme', theme);
    }
};

const updateThemeIcons = (isDark) => {
    const sunIcon = document.getElementById('sun-icon');
    const moonIcon = document.getElementById('moon-icon');
    
    if (isDark) {
        sunIcon?.classList.remove('hidden');
        moonIcon?.classList.add('hidden');
    } else {
        sunIcon?.classList.add('hidden');
        moonIcon?.classList.remove('hidden');
    }
};

const handleThemeToggle = () => {
    const isDark = document.documentElement.classList.toggle('dark');
    localStorage.setItem('theme', isDark ? 'dark' : 'light');
    updateThemeIcons(isDark);
};

// ===========================================
// Sidebar Management
// ===========================================
const toggleSidebar = (open = null) => {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    
    if (!sidebar || !overlay) return;
    
    const isCurrentlyOpen = sidebar.classList.contains('open');
    const shouldOpen = open !== null ? open : !isCurrentlyOpen;
    
    if (shouldOpen) {
        sidebar.classList.add('open');
        overlay.classList.add('active');
    } else {
        sidebar.classList.remove('open');
        overlay.classList.remove('active');
    }
};

// Make toggleSidebar available globally
window.toggleSidebar = toggleSidebar;

const setupSidebar = () => {
    // Main sidebar toggle button
    const sidebarToggleButton = document.getElementById('sidebar-toggle');
    if (sidebarToggleButton) {
        sidebarToggleButton.addEventListener('click', () => toggleSidebar());
    }
    
    // Header sidebar toggle (blog pages)
    const headerSidebarToggle = document.getElementById('header-sidebar-toggle');
    if (headerSidebarToggle) {
        headerSidebarToggle.addEventListener('click', () => toggleSidebar());
    }
    
    // Overlay click to close
    const overlay = document.getElementById('sidebar-overlay');
    if (overlay) {
        overlay.addEventListener('click', () => toggleSidebar(false));
    }
    
    // Close button
    const closeBtn = document.getElementById('sidebar-close-btn');
    if (closeBtn) {
        closeBtn.addEventListener('click', () => toggleSidebar(false));
    }
    
    // Close sidebar when clicking post links
    const sidebar = document.getElementById('sidebar');
    if (sidebar) {
        sidebar.addEventListener('click', (e) => {
            if (e.target && e.target.closest('.post-link')) {
                toggleSidebar(false);
            }
        });
    }
};

// ===========================================
// Blog Header Scroll Behavior
// ===========================================
const setupBlogHeader = () => {
    const header = document.getElementById('page-header');
    if (!header) return;
    
    let lastScrollY = 0;
    
    const handleScroll = () => {
        const currentScrollY = window.scrollY;
        
        if (currentScrollY < 100) {
            header.classList.remove('header-hidden');
        } else if (currentScrollY > lastScrollY) {
            header.classList.add('header-hidden');
        } else {
            header.classList.remove('header-hidden');
        }
        
        lastScrollY = currentScrollY;
    };
    
    window.addEventListener('scroll', handleScroll, { passive: true });
    
    // Header theme toggle
    const headerThemeToggle = document.getElementById('header-theme-toggle');
    if (headerThemeToggle) {
        headerThemeToggle.addEventListener('click', handleThemeToggle);
    }
};

// ===========================================
// Code Copy Buttons
// ===========================================
const setupCopyButtons = () => {
    const codeBlocks = document.querySelectorAll('pre code');
    if (codeBlocks.length === 0) return;
    
    codeBlocks.forEach((codeBlock) => {
        const wrapper = codeBlock.parentElement;
        if (!wrapper) return;
        
        // Skip if already has wrapper or button
        if (wrapper.classList.contains('code-block-wrapper') || 
            wrapper.querySelector('.copy-code-button')) return;
        
        // Create wrapper and move code block
        const newWrapper = document.createElement('div');
        newWrapper.className = 'code-block-wrapper';
        wrapper.insertBefore(newWrapper, codeBlock);
        newWrapper.appendChild(codeBlock);
        
        // Create and add copy button
        const btn = document.createElement('button');
        btn.className = 'copy-code-button';
        btn.setAttribute('aria-label', 'Copy code');
        btn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="9" y="9" width="13" height="13" rx="2" ry="2"/>
            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
        </svg>`;
        
        btn.addEventListener('click', async (e) => {
            e.preventDefault();
            try {
                const text = codeBlock.textContent || '';
                await navigator.clipboard.writeText(text);
                
                const originalHTML = btn.innerHTML;
                btn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"/>
                </svg><span class="btn-text">Copied!</span>`;
                btn.classList.add('copied');
                
                setTimeout(() => {
                    btn.innerHTML = originalHTML;
                    btn.classList.remove('copied');
                }, 2000);
            } catch (err) {
                console.error('Failed to copy code:', err);
            }
        });
        
        newWrapper.appendChild(btn);
    });
};

// ===========================================
// Syntax Highlighting
// ===========================================
const setupHighlighting = () => {
    if (typeof hljs !== 'undefined') {
        hljs.highlightAll();
    }
};

// ===========================================
// View Transitions API
// ===========================================
const setupViewTransitions = () => {
    // Check if View Transitions API is supported
    if (!document.startViewTransition) return;
    
    // Intercept all internal link clicks
    document.addEventListener('click', async (e) => {
        const link = e.target.closest('a');
        if (!link) return;
        
        // Only handle internal links
        const url = new URL(link.href, window.location.origin);
        if (url.origin !== window.location.origin) return;
        
        // Skip if modifier keys are pressed (open in new tab, etc.)
        if (e.ctrlKey || e.metaKey || e.shiftKey) return;
        
        // Skip if it's a download link or has target="_blank"
        if (link.hasAttribute('download') || link.target === '_blank') return;
        
        e.preventDefault();
        
        // Start view transition
        document.startViewTransition(async () => {
            // Fetch the new page
            const response = await fetch(url.href);
            const html = await response.text();
            
            // Parse the new HTML
            const parser = new DOMParser();
            const newDoc = parser.parseFromString(html, 'text/html');
            
            // Update the page content
            document.documentElement.replaceChild(
                newDoc.documentElement.querySelector('head'),
                document.head
            );
            document.documentElement.replaceChild(
                newDoc.documentElement.querySelector('body'),
                document.body
            );
            
            // Update URL
            history.pushState({}, '', url.href);
            
            // Re-run setup functions for the new content
            setupTheme();
            setupSidebar();
            setupBlogHeader();
            setupHighlighting();
            setupCopyButtons();
            
            // Setup theme toggle again
            const themeToggleButton = document.getElementById('theme-toggle');
            if (themeToggleButton) {
                themeToggleButton.addEventListener('click', handleThemeToggle);
            }
        });
    });
    
    // Handle browser back/forward
    window.addEventListener('popstate', () => {
        if (!document.startViewTransition) {
            window.location.reload();
            return;
        }
        
        document.startViewTransition(async () => {
            const response = await fetch(window.location.href);
            const html = await response.text();
            const parser = new DOMParser();
            const newDoc = parser.parseFromString(html, 'text/html');
            
            document.documentElement.replaceChild(
                newDoc.documentElement.querySelector('head'),
                document.head
            );
            document.documentElement.replaceChild(
                newDoc.documentElement.querySelector('body'),
                document.body
            );
            
            setupTheme();
            setupSidebar();
            setupBlogHeader();
            setupHighlighting();
            setupCopyButtons();
            
            const themeToggleButton = document.getElementById('theme-toggle');
            if (themeToggleButton) {
                themeToggleButton.addEventListener('click', handleThemeToggle);
            }
        });
    });
};

// ===========================================
// Initialize Everything
// ===========================================
document.addEventListener('DOMContentLoaded', () => {
    setupTheme();
    setupSidebar();
    setupBlogHeader();
    setupHighlighting();
    setupCopyButtons();
    setupViewTransitions();
    
    // Setup main theme toggle button
    const themeToggleButton = document.getElementById('theme-toggle');
    if (themeToggleButton) {
        themeToggleButton.addEventListener('click', handleThemeToggle);
    }
});
