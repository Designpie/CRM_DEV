# Use the official PHP image as a base image
FROM php:8.1-apache

# Install dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install mbstring xml

# Copy application source code to the container
COPY . /var/www/html/

# Set the working directory
WORKDIR /var/www/html/

# Expose the default port
EXPOSE 80
