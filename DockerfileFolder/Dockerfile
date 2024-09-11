# Use PHP 8.2 Apache image based on Debian Bullseye
FROM php:8.2-apache-bullseye

# Create a non-root user
RUN groupadd -r appuser && useradd -r -g appuser appuser

# Install system dependencies
RUN apt-get update && apt-get install -y --no-install-recommends \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    mariadb-client \
    patch \
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
        zip \
        intl \
        calendar

# Enable Apache modules
RUN a2enmod rewrite ssl headers

# Set working directory
WORKDIR /var/www/html

# Download and extract Dolibarr
RUN curl -L https://github.com/Dolibarr/dolibarr/archive/refs/tags/16.0.4.tar.gz | tar xz --strip-components=1

# Copy and apply security patch
COPY dolibarr-stripe.patch /tmp/
RUN patch -p0 < /tmp/dolibarr-stripe.patch

# Create necessary directories
RUN mkdir -p /var/www/html/documents \
    && mkdir -p /var/www/html/conf

# Set permissions
RUN chown -R appuser:appuser /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod 777 /var/www/html/documents \
    && chmod 777 /var/www/html/conf

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
