# Jared Cervantes - Personal Website & Blog

A modern, responsive personal website and blog built with PHP, featuring a clean design with dark/light mode support and smooth view transitions.

## 🚀 Features

- **Clean, Minimal Design**: Modern typography and layout with attention to detail
- **Dark/Light Mode**: Automatic theme switching with user preference persistence
- **Blog System**: Markdown-based blog with frontmatter support
- **Responsive Design**: Works perfectly on all device sizes
- **Fast Performance**: Built with performance in mind
- **SEO Friendly**: Proper meta tags, structured URLs, and semantic HTML
- **View Transitions**: Smooth animations between page navigations
- **Custom Logo**: Unique animated logo design

## 🛠️ Tech Stack

- **Backend**: PHP 8.0+
- **Markdown Processing**: Parsedown
- **Styling**: Custom CSS with Tailwind-inspired utility classes
- **JavaScript**: Vanilla JS for theme switching and interactions
- **Server**: Apache with mod_rewrite (or any server supporting URL rewriting)

## 📁 Project Structure

```
├── config.php              # Site configuration and constants
├── index.php               # Front controller / router
├── .htaccess               # Apache rewrite rules
├── content/
│   └── blog/               # Markdown blog posts
│       └── 2025/
│           ├── 05/
│           ├── 06/
│           └── ...
├── includes/               # PHP includes and templates
│   ├── functions.php       # Helper functions for blog/content
│   ├── layout.php          # Main HTML layout
│   ├── navigation.php      # Navigation component
│   ├── sidebar.php         # Blog sidebar
│   ├── theme-toggle.php    # Theme switching component
│   └── jc-logo.php         # Animated logo component
├── pages/                  # Page templates
│   ├── home.php           # Home page
│   └── blog.php           # Blog post page
├── public/                # Static assets
│   ├── css/
│   │   └── styles.css     # Main stylesheet
│   ├── js/
│   │   └── main.js        # JavaScript functionality
│   └── favicon.svg        # Site favicon
└── vendor/                # Third-party libraries
    └── Parsedown.php      # Markdown parser
```

## 🏃‍♂️ Getting Started

### Prerequisites

- PHP 8.0 or higher
- Apache web server with mod_rewrite enabled (or equivalent)
- Git

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/your-repo-name.git
   cd your-repo-name
   ```

2. **Configure your web server**

   For Apache, ensure your `.htaccess` file is being processed and mod_rewrite is enabled.

   For other servers, you'll need to configure URL rewriting to route all requests to `index.php`.

3. **Set up the site configuration**

   Edit `config.php` to customize:
   - Site title and description
   - Base URL (leave empty for relative URLs)
   - Error reporting settings

4. **Make sure directories are writable** (if needed for future features)

### Development Server

If you have PHP's built-in server, you can run:

```bash
php -S localhost:8000
```

For a more complete development setup, consider using:
- Laravel Valet
- XAMPP/MAMP
- Docker

## 📝 Writing Blog Posts

Create new blog posts as Markdown files in the `content/blog/` directory. Use the following structure:

### File Organization
```
content/blog/2025/12/my-awesome-post.md
```

### Frontmatter Format
```markdown
---
title: "My Awesome Post"
description: "A brief description of what this post is about"
pubDate: 2025-12-25
draft: false
category: "Technology"
tags: ["php", "web-development", "blogging"]
---

# Post Content Here

Write your post content using standard Markdown syntax.
```

### Frontmatter Fields

- `title` (required): Post title
- `description` (recommended): SEO description and preview text
- `pubDate`: Publication date in YYYY-MM-DD format
- `draft`: Set to `true` to hide from production
- `category`: Post category for organization
- `tags`: Array of tags for the post

## 🎨 Customization

### Styling

The site uses custom CSS in `public/css/styles.css`. Key design elements:

- CSS custom properties for theming
- Responsive grid system
- Smooth transitions and animations
- Typography-focused design

### Logo

Customize the logo in `includes/jc-logo.php`. The logo uses SVG and CSS animations.

### Navigation

Edit `includes/navigation.php` to modify the site navigation.

## 🔧 Configuration

Key configuration options in `config.php`:

- `SITE_TITLE`: Your site name
- `SITE_DESCRIPTION`: Site meta description
- `SITE_URL`: Base URL (leave empty for relative)
- Error reporting settings
- Timezone configuration

## 🌐 Deployment

### Web Server Setup

1. **Apache**: Ensure `.htaccess` is enabled and `AllowOverride All` is set
2. **Nginx**: Configure URL rewriting to pass requests to `index.php`
3. **Other servers**: Set up equivalent URL rewriting rules

### Production Considerations

- Set `display_errors` to `false` in production
- Configure proper error logging
- Set up SSL/TLS certificates
- Consider using a CDN for static assets

## 🤝 Contributing

This is a personal website, but if you find bugs or want to suggest improvements:

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## 📄 License

This project is personal and not currently licensed for public use. Contact me if you'd like to use similar code for your own projects.

## 🙏 Acknowledgments

- [Parsedown](https://parsedown.org/) for Markdown processing
- [Tailwind CSS](https://tailwindcss.com/) for design inspiration
- [Astro](https://astro.build/) for the original inspiration (this was ported from an Astro version)

---

Built with ❤️ by Jared Cervantes