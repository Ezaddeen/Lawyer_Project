# Use the official PHP 8.2 image with FrankenPHP
FROM dunglas/frankenphp:1.1-php8.2-bookworm

# Install system dependencies and required PHP extensions (intl, gd, zip)
RUN apt-get update && apt-get install -y \
    libzip-dev \
    libicu-dev \
    libpng-dev \
    unzip \
    && docker-php-ext-install -j$(nproc) \
    zip \
    intl \
    gd

# --- START: INSTALL COMPOSER ---
# This is the new, corrected part
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
# --- END: INSTALL COMPOSER ---

# Set the working directory
WORKDIR /app

# Copy composer files and install dependencies
COPY composer.json composer.lock ./
RUN composer install --no-scripts --optimize-autoloader


# Copy the rest of the application code
COPY . .

# Generate the Laravel application key if it's not set
RUN if [ ! -f ".env" ]; then cp .env.example .env; fi
RUN php artisan key:generate
RUN php artisan migrate --force
RUN php artisan migrate --force --seed


# Set ownership for storage and bootstrap/cache
RUN chown -R www-data:www-data storage bootstrap/cache


# Expose port 80 for the web server
EXPOSE 80
