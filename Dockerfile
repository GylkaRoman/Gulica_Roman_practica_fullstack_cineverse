FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev \
    libzip-dev

RUN docker-php-ext-install \
    pdo_mysql mbstring exif pcntl bcmath gd opcache zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY docker/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini
COPY docker/php/fpm-pool.conf /usr/local/etc/php-fpm.d/www.conf

WORKDIR /var/www

RUN chown -R www-data:www-data /var/www