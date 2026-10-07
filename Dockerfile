FROM php:8.2-fpm

# Install dependencies sistem & ekstensi PHP
RUN apt-get update && apt-get install -y \
    git zip unzip libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring exts pdo bcmath gd

# Copy Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --no-dev --optimize-autoloader

# Running Laravel
CMD php artisan serve --host=0.0.0.0 --port=10000
EXPOSE 10000