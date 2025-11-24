FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    libzip-dev zip libicu-dev \
    npm \
    && docker-php-ext-install zip intl pdo pdo_mysql

WORKDIR /var/www/html
COPY . .

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN composer install --optimize-autoloader --no-scripts --no-interaction
RUN npm install
RUN npm run build

RUN php artisan storage:link
RUN php artisan optimize:clear

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]
