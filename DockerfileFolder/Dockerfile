FROM php:7.4-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    libzip-dev \
    libonig-dev \
    libxml2-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Configure and install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Enable Apache modules
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy HTML, CSS, and JavaScript files
COPY DockerfileFolder/index.html /var/www/html/index.html
COPY DockerfileFolder/style.css /var/www/html/style.css
COPY DockerfileFolder/script.js /var/www/html/script.js

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expose port 80
EXPOSE 80

# Update Apache configuration to listen on port 80
RUN sed -i 's/Listen 80/Listen 80/' /etc/apache2/ports.conf

# Start Apache
CMD ["apache2-foreground"]
