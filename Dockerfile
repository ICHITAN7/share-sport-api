FROM php:8.3-fpm

# Install required extensions
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    libicu-dev \
    && docker-php-ext-install zip intl

# Copy project files
WORKDIR /var/www/html
COPY . .

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install dependencies
RUN composer install --optimize-autoloader --no-scripts --no-interaction

CMD ["php-fpm"]
