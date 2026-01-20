FROM php:8.1-apache

# Enable Apache rewrite module (needed for URL routing)
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . /var/www/html/

# Set proper permissions for Apache
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html

# Create .htaccess if it doesn't exist (for URL rewriting)
RUN if [ ! -f .htaccess ]; then \
        echo "RewriteEngine On" > .htaccess && \
        echo "RewriteCond %{REQUEST_FILENAME} !-f" >> .htaccess && \
        echo "RewriteCond %{REQUEST_FILENAME} !-d" >> .htaccess && \
        echo "RewriteRule . index.php [L]" >> .htaccess; \
    fi

# Expose port 80 (internal container port)
EXPOSE 80

# Start Apache in foreground
CMD ["apache2-foreground"]