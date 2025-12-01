FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libicu-dev libpq-dev libxml2-dev \
    && docker-php-ext-install zip intl pdo pdo_pgsql xml \
    && docker-php-ext-enable opcache

WORKDIR /var/www/html

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
