# Use the official PHP 8.2 image with FrankenPHP
FROM dunglas/frankenphp:1.1-php8.2-bookworm

# Install system dependencies and required PHP extensions
# This is where we add intl, gd, and zip
RUN apt-get update && apt-get install -y \
    libzip-dev \
    libicu-dev \
    libpng-dev \
    && docker-php-ext-install -j$(nproc) \
    zip \
    intl \
    gd

# Set the working directory
WORKDIR /app

# Copy composer files and install dependencies
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --optimize-autoloader

# Copy the rest of the application code
COPY . .

# Generate the Laravel application key if it's not set
RUN if [ ! -f ".env" ]; then cp .env.example .env; fi
RUN php artisan key:generate

# Set ownership for storage and bootstrap/cache
RUN chown -R frankenphp:frankenphp storage bootstrap/cache

# Expose port 80 for the web server
EXPOSE 80
