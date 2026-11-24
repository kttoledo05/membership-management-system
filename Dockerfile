FROM node:20-alpine AS frontend

WORKDIR /app

COPY package*.json ./
RUN npm ci

COPY resources ./resources
COPY vite.config.js ./

RUN npm run build


FROM php:8.3-apache

RUN apt-get update

RUN apt-get install -y \
    libpq-dev \
    libzip-dev \
    libonig-dev \
    unzip \
    git

RUN docker-php-ext-install \
    pdo_pgsql \
    mbstring \
    bcmath \
    zip

RUN a2enmod rewrite

RUN rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --no-interaction \
    --no-scripts \
    --prefer-dist \
    --optimize-autoloader

COPY . .

RUN php artisan package:discover --ansi

COPY --from=frontend /app/public/build ./public/build

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/000-default.conf \
    /etc/apache2/apache2.conf

RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 80

CMD php artisan migrate --force && apache2-foreground