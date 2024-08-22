# Use a slim, recent PHP version
FROM php:8.2-apache-bullseye-slim

# Create a non-root user
RUN groupadd -r appuser && useradd -r -g appuser appuser

# Install system dependencies with specific versions
RUN apt-get update && apt-get install -y --no-install-recommends \
    libpng-dev=1.6.37-3 \
    libjpeg-dev=1:2.0.6-4 \
    libfreetype6-dev=2.10.4+dfsg-1+deb11u1 \
    libzip-dev=1.7.3-1+b1 \
    libonig-dev=6.9.6-1.1 \
    libxml2-dev=2.9.10+dfsg-6.7+deb11u3 \
    && rm -rf /var/lib/apt/lists/*

# Configure and install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip

# Enable Apache modules
RUN a2enmod rewrite ssl headers

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY --chown=appuser:appuser index.html style.css script.js ./

# Set permissions
RUN chown -R appuser:appuser /var/www/html \
    && chmod -R 755 /var/www/html

# Configure PHP for better security
RUN { \
    echo 'expose_php = Off'; \
    echo 'display_errors = Off'; \
    echo 'log_errors = On'; \
    echo 'error_reporting = E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED'; \
} > /usr/local/etc/php/conf.d/security.ini

# Configure Apache for better security
RUN echo "ServerTokens Prod" >> /etc/apache2/apache2.conf \
    && echo "ServerSignature Off" >> /etc/apache2/apache2.conf \
    && echo "Header set X-Content-Type-Options: nosniff" >> /etc/apache2/conf-available/security.conf \
    && echo "Header set X-Frame-Options: SAMEORIGIN" >> /etc/apache2/conf-available/security.conf \
    && echo "Header set X-XSS-Protection: 1; mode=block" >> /etc/apache2/conf-available/security.conf \
    && echo "Header set Content-Security-Policy \"default-src 'self';\"" >> /etc/apache2/conf-available/security.conf \
    && a2enconf security

# Update Apache configuration to listen on port 8080
RUN sed -i 's/Listen 80/Listen 8080/' /etc/apache2/ports.conf \
    && sed -i 's/<VirtualHost \*:80>/<VirtualHost *:8080>/' /etc/apache2/sites-available/000-default.conf

# Expose port 8080
EXPOSE 8080

# Switch to non-root user
USER appuser

# Start Apache
CMD ["apache2-foreground"]
