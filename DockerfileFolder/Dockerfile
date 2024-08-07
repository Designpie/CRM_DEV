# Use an official PHP runtime as a parent image
FROM php:7.4-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd mysqli pdo pdo_mysql

# Enable Apache modules
RUN a2enmod rewrite

# Download and extract Dolibarr
RUN curl -L -o dolibarr.zip https://github.com/Dolibarr/dolibarr/archive/refs/tags/15.0.3.zip \
    && unzip dolibarr.zip \
    && mv dolibarr-15.0.3 /var/www/html/dolibarr \
    && chown -R www-data:www-data /var/www/html/dolibarr \
    && rm dolibarr.zip

# Copy custom configuration
COPY dolibarr.conf /etc/apache2/sites-available/000-default.conf

# Expose port 80
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
