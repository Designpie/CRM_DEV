# Use the official PHP image as a base image
FROM php:8.1-apache

# Install dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    libonig-dev \
    libxml2-dev \
    git \
    unzip \
    && docker-php-ext-install mbstring xml

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy application source code to the container
COPY . /var/www/html/

# Set the working directory
WORKDIR /var/www/html/

# Install Composer dependencies if composer.json exists
RUN if [ -f "composer.json" ]; then composer install --no-dev --optimize-autoloader; fi

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html

# Expose the default port
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
